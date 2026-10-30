Franktech Enterprises website - deployment
1. Upload EVERYTHING in this folder (including the hidden .htaccess file) to public_html for your domain.
2. Turn on SSL (AutoSSL / Let's Encrypt). .htaccess forces https and the www. version of the domain.
3. Pages: /  and  /about/   (plus 404.html for missing pages)
4. The quote form posts to contact.php, which emails franktechenterprises14@gmail.com. This needs PHP mail() on the host (standard on cPanel). If it is unavailable, visitors still get the "Send on WhatsApp" button and the phone/email links.
5. DOMAIN: the site is set up for https://www.franktechenterprises.co.ke (canonical links, sitemap, robots, social tags). If you use a different domain, replace that address in index.html's built pages, sitemap.xml, robots.txt and llms.txt (or change SITE.url in src/data.js and rebuild).
6. Submit /sitemap.xml to Google Search Console and Bing Webmaster Tools.
