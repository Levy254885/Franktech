<?php
// Receives the quote-request form and emails it to Franktech Enterprises.
// Works on standard cPanel/Apache hosting where PHP mail() is enabled.
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$TO = 'franktechenterprises14@gmail.com';

function out($ok, $code = 200) { http_response_code($code); echo json_encode(['ok' => $ok]); exit; }
function clean($v, $max = 2000) {
  $v = trim((string)$v);
  $v = str_replace(["\r", "\n"], ' ', $v);           // block header injection
  return mb_substr(strip_tags($v), 0, $max);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') out(false, 405);
if (!empty($_POST['website'])) out(true);             // honeypot: pretend success to bots

$name     = clean($_POST['name'] ?? '', 120);
$phone    = clean($_POST['phone'] ?? '', 40);
$email    = clean($_POST['email'] ?? '', 160);
$location = clean($_POST['location'] ?? '', 160);
$service  = clean($_POST['service'] ?? '', 120);
$message  = trim(strip_tags((string)($_POST['message'] ?? '')));
$message  = mb_substr($message, 0, 4000);

if ($name === '' || $phone === '' || $message === '') out(false, 422);
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) out(false, 422);

$host = preg_replace('/^www\./', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
$subject = 'New website enquiry' . ($service ? " - $service" : '') . " - $name";
$body = "New enquiry from the Franktech Enterprises website\n\n"
      . "Name: $name\nPhone: $phone\nEmail: " . ($email ?: '-') . "\n"
      . "Location: " . ($location ?: '-') . "\nService: " . ($service ?: '-') . "\n\n"
      . "Message:\n$message\n";

$headers = "From: Franktech Website <no-reply@$host>\r\n"
         . ($email ? "Reply-To: $email\r\n" : '')
         . "Content-Type: text/plain; charset=UTF-8\r\n";

out(@mail($TO, '=?UTF-8?B?' . base64_encode($subject) . '?=', $body, $headers), 200);
