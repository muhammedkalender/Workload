LARAVEL 8.13

Veritabanı bilgileri .env altında düzenlenmeli, test için MySQL kullanıldı<br>

Composer paketleri ve php paketleri kurulduktan sonra serve etmeden önce çalışmaya hazırlanması için<br>

Tabloların kurulumu için<br>

<b>php artisan migrate</b>

Örnek Dataların işlenmesi için<br>

<b>php artisan db:seed --class=DeveloperSeeder</b>

Verilerin çekilmesi için<br>

<b>php artisan feed:jobs</b>
