<?php
  header('Content-type: application/xml; charset="ISO-8859-1"',true);  
?>
 
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc><?= base_url() ?></loc>
    <lastmod><?= gmdate('Y-m-d\TH:i:s\Z') ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.1</priority>
  </url>
  <url>
    <loc><?= base_url('home') ?></loc>
    <lastmod><?= gmdate('Y-m-d\TH:i:s\Z') ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.1</priority>
  </url>
  <url>
    <loc><?= base_url('auth') ?></loc>
    <lastmod><?= gmdate('Y-m-d\TH:i:s\Z') ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.1</priority>
  </url>
  <url>
    <loc><?= base_url('forget') ?></loc>
    <lastmod><?= gmdate('Y-m-d\TH:i:s\Z') ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.1</priority>
  </url>
  <url>
    <loc><?= base_url('panduan') ?></loc>
    <lastmod><?= gmdate('Y-m-d\TH:i:s\Z') ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.1</priority>
  </url>
</urlset>