# HỒ SƠ BÀN GIAO KỸ THUẬT & HƯỚNG DẪN TRIỂN KHAI VẬN HÀNH
### HỆ THỐNG PHẦN MỀM WINLINE VIETNAM (CORE E-COMMERCE & HVAC ENGINE)

- **Đơn vị phát triển:** Mắt Bão WS (MatBao Web Solutions)
- **Đơn vị tiếp nhận:** Công ty TNHH Winline Việt Nam
- **Phiên bản:** Release v1.0.0 (Production Ready)
- **Ngày lập hồ sơ:** 29/09/2026

---

## 1. TỔNG QUAN KIẾN TRÚC KỸ THUẬT (SYSTEM ARCHITECTURE)

Hệ thống Winline.vn được xây dựng trên kiến trúc hướng dịch vụ hiện đại, tối ưu cho bài toán thương mại điện tử kết hợp công cụ tính toán kỹ thuật chuyên ngành:

```
[Trình duyệt Khách hàng & Kỹ sư]      [Trình duyệt Quản trị viên Winline]
                │                                    │
                ▼                                    ▼
       ┌────────────────────────────────────────────────────────┐
       │      Web Server: Nginx / Apache (Reverse Proxy, SSL)   │
       └────────────────────────────────────────────────────────┘
                                    │
                                    ▼
       ┌────────────────────────────────────────────────────────┐
       │                Laravel 12 LTS Core Framework           │
       │  ┌──────────────────────┐    ┌──────────────────────┐  │
       │  │  Storefront Module   │    │  Admin Core Panel    │  │
       │  │  - Quạt HVAC Catalog │    │  - 17 Phân hệ nghiệp │  │
       │  │  - Công cụ tính quạt │    │    vụ chuyên sâu     │  │
       │  │  - Giỏ hàng & RFQ    │    │  - Activity Audit    │  │
       │  └──────────────────────┘    └──────────────────────┘  │
       │  ┌──────────────────────────────────────────────────┐  │
       │  │  FanCalculationService & ComparisonMatrix Engine │  │
       │  └──────────────────────────────────────────────────┘  │
       └────────────────────────────────────────────────────────┘
                                    │
                     ┌──────────────┴──────────────┐
                     ▼                             ▼
       ┌───────────────────────────┐ ┌───────────────────────────┐
       │ SQLite / MySQL Database   │ │ Local / S3 Media Storage  │
       │ - Schema & Migrations     │ │ - Ảnh sản phẩm, catalog   │
       │ - Indexing lưu lượng quạt │ │ - Bản vẽ kỹ thuật PDF     │
       └───────────────────────────┘ └───────────────────────────┘
```

### Các công nghệ cốt lõi:
- **Backend Framework:** Laravel 12.x (PHP 8.2 trở lên).
- **Frontend Admin:** Bootstrap 5, Solar Iconify Icons, Quicksand Font, SweetAlert2.
- **Frontend Storefront:** Modern CSS Grid/Flexbox, Alpine.js, FontAwesome 6, IBM Plex Mono & Plus Jakarta Sans.
- **HVAC Calculation Engine:** `FanCalculationService.php` (Thuật toán tính thể tích phòng, đối chiếu bội số trao đổi không khí TCVN và lọc model quạt tự động).
- **Hệ thống Kiểm thử:** Playwright E2E Testing Suite (Xác thực 100% không lỗi giao diện, không lỗi console).

---

## 2. YÊU CẦU HẠ TẦNG MÁY CHỦ (SERVER REQUIREMENTS)

Để đưa hệ thống lên môi trường Production (VPS / Cloud Server / Hosting doanh nghiệp Mắt Bão), máy chủ cần đáp ứng cấu hình tối thiểu:

- **Hệ điều hành:** Ubuntu 22.04 LTS / 24.04 LTS, Debian 12 hoặc CloudLinux.
- **PHP:** Phiên bản 8.2 trở lên với các extension:
  - `php-fpm`, `php-cli`, `php-sqlite3` (hoặc `php-mysql`), `php-mbstring`, `php-xml`, `php-curl`, `php-zip`, `php-gd`, `php-intl`, `php-bcmath`.
- **Web Server:** Nginx 1.22+ hoặc Apache 2.4+ (có module `mod_rewrite`).
- **Composer:** Phiên bản 2.6+
- **Node.js & NPM:** Node.js v18 LTS trở lên.
- **SSL Certificate:** Let's Encrypt hoặc chứng chỉ SSL có phí kích hoạt giao thức HTTPS bắt buộc.

---

## 3. HƯỚNG DẪN TRIỂN KHAI LÊN PRODUCTION (DEPLOYMENT STEPS)

### Bước 1: Kéo mã nguồn về thư mục web
```bash
cd /var/www/
git clone https://github.com/matbao-ws/winlinevn073.mbws.vn.git winline.vn
cd winline.vn
git checkout main
```

### Bước 2: Cài đặt các gói phụ thuộc PHP & Asset
```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

### Bước 3: Thiết lập file môi trường `.env`
Sao chép file `.env.example` thành `.env` và cấu hình các thông số:
```env
APP_NAME="Winline Vietnam"
APP_ENV=production
APP_KEY=base64:... (chạy php artisan key:generate)
APP_DEBUG=false
APP_URL=https://winline.vn

# Cơ sở dữ liệu (SQLite hoặc MySQL)
DB_CONNECTION=sqlite
# Nếu sử dụng MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=winline_prod
# DB_USERNAME=winline_user
# DB_PASSWORD=SecretPassword2026!

# Mail SMTP gửi thông báo đơn hàng & RFQ
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=winlinevietnam@gmail.com
MAIL_PASSWORD=app_password_here
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="winlinevietnam@gmail.com"
MAIL_FROM_NAME="Winline Vietnam"
```

### Bước 4: Khởi tạo Database & Phân quyền thư mục
```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link

# Phân quyền thư mục ghi log và bộ nhớ đệm
sudo chown -R www-data:www-data storage bootstrap/cache public/docs public/assets
sudo chmod -R 775 storage bootstrap/cache
```

### Bước 5: Cấu hình VirtualHost Nginx
Tạo file cấu hình `/etc/nginx/sites-available/winline.vn`:
```nginx
server {
    listen 80;
    server_name winline.vn www.winline.vn;
    return 301 https://winline.vn$request_uri;
}

server {
    listen 443 ssl http2;
    server_name winline.vn www.winline.vn;
    root /var/www/winline.vn/public;

    ssl_certificate /etc/letsencrypt/live/winline.vn/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/winline.vn/privkey.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Bước 6: Tối ưu bộ nhớ đệm hiệu năng cao
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 4. QUY TRÌNH SAO LƯU & PHỤC HỒI DỮ LIỆU (BACKUP & RECOVERY)

### 1. Kế hoạch sao lưu định kỳ khuyến nghị:
- **Sao lưu cơ sở dữ liệu:** Tự động chạy hằng ngày lúc 01:00 AM.
- **Sao lưu thư mục media (`public/assets`, `storage/app`):** Hằng tuần lúc 02:00 AM Chủ Nhật.

### 2. Lệnh sao lưu nhanh:
```bash
# 1. Sao lưu database SQLite
cp /var/www/winline.vn/database/database.sqlite /backup/db_winline_$(date +%Y%m%d).sqlite

# 2. Sao lưu file tải lên
tar -czf /backup/media_winline_$(date +%Y%m%d).tar.gz /var/www/winline.vn/public/client-assets/images /var/www/winline.vn/storage/app/public
```

### 3. Phục hồi khi có sự cố (Disaster Recovery):
```bash
# Phục hồi database
cp /backup/db_winline_2026xxxx.sqlite /var/www/winline.vn/database/database.sqlite
sudo chown www-data:www-data /var/www/winline.vn/database/database.sqlite

# Xóa cache
php artisan cache:clear
php artisan optimize:clear
```

---

## 5. THÔNG TIN BÀN GIAO TÀI KHOẢN VẬN HÀNH

| Phân hệ | Đường dẫn truy cập | Tài khoản đăng nhập | Mật khẩu ban đầu | Quyền hạn |
| :--- | :--- | :--- | :--- | :--- |
| **Admin Superadmin** | `https://winline.vn/vi/admin/login` | `winlinevietnam@gmail.com` | `Admin@Winline2026!` | Toàn quyền quản trị hệ thống |
| **Cẩm nang hướng dẫn** | `https://winline.vn/huong-dan-su-dung` | Truy cập trực tiếp hoặc bấm nút trên Admin Header | Không cần mật khẩu | Tra cứu toàn bộ 17 chương cẩm nang |
| **Tài liệu PDF bàn giao** | `https://winline.vn/docs/Huong_Dan_Su_Dung_Admin_Winline.pdf` | Tải về xem ngoại tuyến | Không cần mật khẩu | File PDF màu 30 trang in ấn |

---

## 6. THÔNG TIN ĐẦU MỐI KỸ THUẬT HỖ TRỢ (MATBAO WS)

- **Tổng đài chăm sóc & hỗ trợ kỹ thuật:** 1900 1830 (Nhánh 2 - Hỗ trợ Web & Phần mềm)
- **Email phòng kỹ thuật:** support@matbao.ws
- **Cổng hỗ trợ trực tuyến:** https://support.matbao.ws
- **Thời hạn bảo hành miễn phí:** 12 tháng kể từ ngày ký biên bản nghiệm thu.
