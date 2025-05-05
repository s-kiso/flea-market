<h1>模擬案件_フリマアプリ</h1>
<h2>環境構築</h2>
<h3>Dockerビルド</h3>
<ol>
  <li>git clone リンク</li>
  <li>docker-compose up -d --build</li>
</ol>

<h3>Laravel環境構築</h3>
<ol>
  <li>docker-compose exec php bash</li>
  <li>composer install</li>
  <li>cp .env.example .env</li>
  <li>作成したenvファイル内を下記の通り修正
    <ul>
      <li>DB_HOST=mysql</li>
      <li>DB_DATABASE=laravel_db</li>
      <li>DB_USERNAME=laravel_user</li>
      <li>DB_PASSWORD=laravel_pass</li>
    </ul>
  </li>
  <li>php artisan key:generate</li>
  <li>php artisan migrate</li>
  <li>php artisan db:seed</li>
  <li>php artisan storage:link</li>
</ol>

<h3>使用技術</h3>
<ul>
  <li>Laravel Framework 8.83.8</li>
  <li>MySQL 8.0.26</li>
</ul>
<h3>ER図</h3>
<p>URL：https://github.com/s-kiso/mogitate/blob/main/mogitate.drawio.png</p>
<h3>URL</h3>
<ul>
  <li>開発環境:http://localhost/</li>
  <li>phpMyAdmin:http://localhost:8080/</li>
</ul>
