<h1>模擬案件_フリマアプリ</h1>
<h2>環境構築</h2>
<ol>
  <li>git clone git@github.com:s-kiso/flea-market.git</li>
  <li>Dockerを起動する</li>
  <li>make init（プロジェクト直下で実行）</li>
  <li>作成されたenvファイル内を下記の通り修正
    <ul>
      <li>DB_HOST=mysql</li>
      <li>DB_DATABASE=laravel_db</li>
      <li>DB_USERNAME=laravel_user</li>
      <li>DB_PASSWORD=laravel_pass</li>
      <li>MAIL_FROM_ADDRESSに任意のアドレスを入力（mailhogを使用）</li>
    </ul>
  </li>
  <li>make fresh（プロジェクト直下で実行）</li>
</ol>

<h2>テストアカウント</h2>
  <p>いずれのユーザーもメール認証実施済み</p>
  <ul>
    <li>name: ユーザー1</li>
    <li>email: test1@example.com</li>
    <li>password: password</li>
    <li>CO01～CO05の商品を出品</li>
  </ul>
  <ul>
    <li>name: ユーザー2</li>
    <li>email: test2@example.com</li>
    <li>password: password</li>
    <li>CO06～CO10の商品を出品</li>
  </ul>
  <ul>
    <li>name: ユーザー3</li>
    <li>email: test3@example.com</li>
    <li>password: password</li>
    <li>商品データの紐づけなし</li>
  </ul>

<h3>使用技術</h3>
<ul>
  <li>Laravel Framework 8.83.8</li>
  <li>MySQL 8.0.26</li>
</ul>
<h3>ER図</h3>

<img width="1201" height="1031" alt="Image" src="https://github.com/user-attachments/assets/376fefeb-0a6d-44bd-b8c2-0ee1bc7e7449" />

<h3>URL</h3>
<ul>
  <li>開発環境（トップページ）: http://localhost/</li>
  <li>phpMyAdmin: http://localhost:8080/</li>
  <li>mailhog: http://localhost:8025/</li>
</ul>

<h3>備考</h3>
<ul>
  <li>機能要件FN009「入力情報保持機能」については実装できておりません。</li>
</ul>
