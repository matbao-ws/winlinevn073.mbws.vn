# TÀI LIỆU HƯỚNG DẪN SỬ DỤNG HỆ THỐNG QUẢN TRỊ (ADMIN USER MANUAL)
**Website:** Winline.vn (Dự án: `winlinevn073.mbws.vn`)  
**Đơn vị phát triển:** Mắt Bão WS  
**Phiên bản:** 2.0 (Cập nhật tháng 09/2026)  
**Ngôn ngữ:** Tiếng Việt  

---

## MỤC LỤC

1. [TỔNG QUAN HỆ THỐNG & ĐĂNG NHẬP](#1-tổng-quan-hệ-thống--đăng-nhập)
   * 1.1. Đường dẫn đăng nhập & Yêu cầu trình duyệt
   * 1.2. Đăng nhập hệ thống
   * 1.3. Bố cục giao diện trang Quản trị (Dashboard)
2. [QUẢN LÝ TÀI KHOẢN & PHÂN QUYỀN (USER & ROLES)](#2-quản-lý-tài-khoản--phân-quyền-user--roles)
   * 2.1. Thêm mới tài khoản nhân viên
   * 2.2. Khóa / Mở khóa tài khoản nhân viên (Disable / Enable)
   * 2.3. Đổi mật khẩu tài khoản
   * 2.4. Phân quyền theo vai trò (Roles & Permissions)
3. [QUẢN LÝ SẢN PHẨM & THÔNG SỐ KỸ THUẬT HVAC](#3-quản-lý-sản-phẩm--thông-số-kỹ-thuật-hvac)
   * 3.1. Thêm mới một sản phẩm
   * 3.2. Cấu hình thông số kỹ thuật HVAC (Dùng cho Công cụ tính quạt)
   * 3.3. Quản lý Danh mục sản phẩm (Cấp 1, Cấp 2, Cấp 3)
   * 3.4. Quản lý Thương hiệu sản phẩm
4. [QUẢN LÝ BẢNG MA TRẬN SO SÁNH MODEL (MODEL COMPARISON TABLES)](#4-quản-lý-bảng-ma-trận-so-sánh-model-model-comparison-tables)
   * 4.1. Ý nghĩa và cơ chế hoạt động
   * 4.2. Tạo mới một Bảng so sánh model
   * 4.3. Gán bảng so sánh vào Trang chi tiết sản phẩm
   * 4.4. Nhúng bảng so sánh vào Bài viết tin tức bằng Shortcode
   * 4.5. Nhân bản (Duplicate) bảng so sánh mẫu
5. [QUẢN LÝ ĐƠN HÀNG & TIẾP NHẬN BÁO GIÁ](#5-quản-lý-đơn-hàng--tiếp-nhận-báo-giá)
   * 5.1. Xem danh sách và lọc đơn hàng
   * 5.2. Xử lý quy trình trạng thái đơn hàng
   * 5.3. In phiếu đơn hàng / Phiếu đóng gói
   * 5.4. Tiếp nhận thông tin Liên hệ & Yêu cầu báo giá (RFQ)
6. [QUẢN LÝ NỘI DUNG MARKETING & CMS (TIN TỨC, TRANG TĨNH, BANNER)](#6-quản-lý-nội-dung-marketing--cms-tin-tức-trang-tĩnh-banner)
   * 6.1. Đăng bài viết tin tức / Dự án / Giải pháp kỹ thuật
   * 6.2. Tối ưu SEO cho bài viết với bộ chấm điểm chuẩn
   * 6.3. Quản lý Trang tĩnh (Giới thiệu, Chính sách, Hướng dẫn)
   * 6.4. Quản lý Banner Slider trang chủ
   * 6.5. Cấu hình Menu điều hướng Storefront
7. [CHƯƠNG TRÌNH KHUYẾN MÃI & MÃ GIẢM GIÁ (VOUCHER)](#7-chương-trình-khuyến-mãi--mã-giảm-giá-voucher)
   * 7.1. Tạo mã giảm giá (Voucher)
   * 7.2. Tạo chương trình khuyến mãi tự động (Flash Sale)
8. [CẤU HÌNH HỆ THỐNG (SETTINGS)](#8-cấu-hình-hệ-thống-settings)
   * 8.1. Thông tin chung website (Hotline, Email, Địa chỉ, Logo)
   * 8.2. Cấu hình cổng thanh toán (COD, Chuyển khoản VietQR, VNPAY)
   * 8.3. Cấu hình Email gửi tự động (SMTP)
9. [BẢNG TRA CỨU & TIÊU CHUẨN DỮ LIỆU (REFERENCE)](#9-bảng-tra-cứu--tiêu-chuẩn-dữ-liệu-reference)
   * 9.1. Quy chuẩn kích thước hình ảnh tối ưu
   * 9.2. Bảng ý nghĩa các trạng thái đơn hàng
10. [HỎI ĐÁP & XỬ LÝ SỰ CỐ THƯỜNG GẶP (TROUBLESHOOTING & FAQ)](#10-hỏi-đáp--xử-lý-sự-cố-thường-gặp-troubleshooting--faq)

---

# 1. TỔNG QUAN HỆ THỐNG & ĐĂNG NHẬP

### 1.1. Đường dẫn đăng nhập & Yêu cầu trình duyệt
* **Đường dẫn quản trị:** `https://winline.vn/vi/admin` *(hoặc tên miền phát triển `https://winlinevn073.mbws.vn/vi/admin`)*.
* **Trình duyệt khuyến nghị:** Google Chrome, Microsoft Edge, Cốc Cốc hoặc Safari phiên bản mới nhất.

---

### 1.2. Đăng nhập hệ thống

**Mục tiêu:** Xác thực danh tính người dùng được cấp quyền để truy cập vào trung tâm điều hành website.

**Các bước thực hiện:**
1. Mở trình duyệt và truy cập đường dẫn: `https://[tên_miền]/vi/admin/login`
2. Nhập **Email quản trị** và **Mật khẩu** đã được cấp.
3. Bấm nút **Đăng nhập**.

| # | Vùng / Trường | Thao tác & Mô tả ý nghĩa |
|---|---|---|
| 1 | **Email** | Nhập email quản trị viên (Ví dụ: `winlinevietnam@gmail.com`). |
| 2 | **Mật khẩu** | Nhập mật khẩu bảo mật (tối thiểu 8 ký tự). |
| 3 | **Ghi nhớ đăng nhập** | Tích chọn nếu dùng máy tính cá nhân để duy trì phiên làm việc. |
| 4 | **Nút Đăng nhập** | Xác thực và chuyển hướng vào Bảng điều khiển (Dashboard). |

> [!NOTE]
> Để đảm bảo an toàn thông tin, nếu nhập sai mật khẩu quá 5 lần liên tiếp, hệ thống sẽ tạm khóa đăng nhập từ địa chỉ IP đó trong 60 giây.

---

### 1.3. Bố cục giao diện trang Quản trị (Dashboard)

Giao diện quản trị được chia làm 3 khu vực chính:
1. **Thanh bên trái (Sidebar Menu):** Chứa toàn bộ các phân hệ quản lý: Đơn hàng, Khách hàng, Sản phẩm, Bảng so sánh model, Khuyến mãi, Bài viết, Banner, Menu, Cấu hình.
2. **Thanh điều hướng trên cùng (Top Navigation):** Hiển thị nút bật/tắt menu bên trái, chuyển đổi ngôn ngữ (VI / EN), biểu tượng chuông thông báo và thông tin tài khoản cá nhân.
3. **Khu vực hiển thị nội dung chính:** Thống kê biểu đồ doanh thu theo tuần/tháng, số lượng đơn hàng mới, sản phẩm bán chạy và các thao tác nghiệp vụ.

---

# 2. QUẢN LÝ TÀI KHOẢN & PHÂN QUYỀN (USER & ROLES)

### 2.1. Thêm mới tài khoản nhân viên

**Mục tiêu:** Tạo tài khoản riêng biệt cho nhân viên kinh doanh, kế toán hoặc biên tập viên nội dung để kiểm soát công việc và ghi nhận nhật ký hoạt động.

**Các bước thực hiện:**
1. Vào menu **Quản lý người dùng** $\rightarrow$ chọn **Danh sách người dùng**.
2. Nhấp vào nút **Thêm người dùng mới** ở góc trên bên phải.
3. Điền các trường thông tin: Họ và tên, Email, Mật khẩu, Chọn vai trò (Role).
4. Nhấp nút **Lưu thông tin**.

| # | Vùng / Trường | Thao tác & Mô tả ý nghĩa |
|---|---|---|
| 1 | **Họ và tên** | Nhập tên nhân viên (Ví dụ: *Nguyễn Văn A*). |
| 2 | **Email** | Email đăng nhập, phải là duy nhất trên hệ thống. |
| 3 | **Mật khẩu** | Mật khẩu ban đầu (yêu cầu từ 8 ký tự trở lên). |
| 4 | **Vai trò (Role)** | Chọn nhóm quyền: *Super Admin, Quản trị viên, Quản lý bán hàng, Biên tập viên*. |
| 5 | **Trạng thái** | Tích chọn **Kích hoạt** để tài khoản có thể đăng nhập ngay. |

---

### 2.2. Khóa / Mở khóa tài khoản nhân viên (Disable / Enable)

**Mục tiêu:** Khi nhân viên nghỉ việc hoặc tạm dừng công tác, quản trị viên có thể khóa tài khoản ngay lập tức mà không làm mất lịch sử các đơn hàng hoặc bài viết nhân viên đó đã tạo.

**Các bước thực hiện:**
1. Vào **Quản lý người dùng** $\rightarrow$ **Danh sách người dùng**.
2. Tìm tài khoản cần thao tác trong danh sách $\rightarrow$ nhấp nút **Chỉnh sửa** (biểu tượng cây bút).
3. Tại mục **Trạng thái tài khoản**:
   * Để khóa: Bỏ chọn ô **Kích hoạt (Active)**.
   * Để mở lại: Tích chọn ô **Kích hoạt (Active)**.
4. Bấm nút **Lưu thay đổi**.

| # | Trạng thái | Ý nghĩa đối với người dùng |
|---|---|---|
| 1 | **Đang hoạt động (Active)** | Đăng nhập bình thường, thao tác các tính năng theo đúng vai trò được phân quyền. |
| 2 | **Bị khóa (Disabled)** | Hệ thống tự động hủy toàn bộ phiên đăng nhập hiện tại. Nhân viên không thể truy cập lại vào hệ thống. |

---

### 2.3. Đổi mật khẩu tài khoản
1. Tại màn hình chỉnh sửa tài khoản người dùng, nhập mật khẩu mới vào ô **Mật khẩu mới**.
2. Nhập lại vào ô **Xác nhận mật khẩu mới**.
3. Để trống hai ô này nếu không có nhu cầu đổi mật khẩu.
4. Bấm **Lưu thay đổi**.

---

### 2.4. Phân quyền theo vai trò (Roles & Permissions)

**Mục tiêu:** Đảm bảo nguyên tắc bảo mật: nhân viên bán hàng chỉ thấy đơn hàng và liên hệ; biên tập viên chỉ thấy bài viết và banner; chỉ Giám đốc/Superadmin mới thấy cấu hình hệ thống và doanh thu.

**Các bước thực hiện:**
1. Vào **Quản lý người dùng** $\rightarrow$ chọn **Vai trò & Quyền hạn**.
2. Nhấp nút **Thêm vai trò** (hoặc chọn **Sửa** vai trò đang có).
3. Đặt **Tên vai trò** (Ví dụ: *Nhân viên kinh doanh HVAC*).
4. Tích chọn các nhóm quyền tương ứng:
   * `orders.*`: Xem, xác nhận, cập nhật trạng thái đơn hàng.
   * `products.*`: Thêm, sửa, xóa sản phẩm và bảng so sánh.
   * `posts.*`: Đăng và quản lý bài viết tin tức.
   * `contacts.*`: Xem và phản hồi yêu cầu báo giá của khách.
5. Bấm **Lưu vai trò**.

---

# 3. QUẢN LÝ SẢN PHẨM & THÔNG SỐ KỸ THUẬT HVAC

### 3.1. Thêm mới một sản phẩm

**Mục tiêu:** Đăng sản phẩm mới lên website đầy đủ hình ảnh, thông số kỹ thuật, giá bán và cấu hình SEO.

**Các bước thực hiện:**
1. Vào menu **Sản phẩm** $\rightarrow$ **Danh sách sản phẩm**.
2. Bấm nút **Thêm sản phẩm mới**.
3. Điền thông tin cơ bản:
   * **Tên sản phẩm:** Tên rõ ràng, chứa Model (Ví dụ: *Quạt thông gió vuông Komasu 1380x1380x400mm*).
   * **Mã sản phẩm (SKU):** Bắt buộc duy nhất (Ví dụ: *KM-VUONG-1380*). Nhân viên và khách hàng sẽ dùng mã này để trao đổi nhanh.
   * **Danh mục:** Chọn danh mục phù hợp (Ví dụ: *Quạt thông gió công nghiệp*).
   * **Thương hiệu:** Chọn hãng (Ví dụ: *Komasu*).
   * **Giá bán:** Nhập giá bán thực tế (VNĐ).
   * **Giá niêm yết (Gạch ngang):** Nhập giá gốc trước khi giảm (nếu có).
4. Tải lên **Ảnh đại diện** và các ảnh chi tiết sản phẩm.
5. Nhập nội dung mô tả chi tiết sản phẩm trong trình soạn thảo.
6. Cấu hình thông số kỹ thuật HVAC (xem mục 3.2).
7. Bấm **Lưu sản phẩm**.

---

### 3.2. Cấu hình thông số kỹ thuật HVAC (Dùng cho Công cụ tính quạt)

> [!IMPORTANT]
> Đây là các trường dữ liệu đặc thù của Winline. Nhập chính xác các thông số này sẽ giúp sản phẩm **tự động hiển thị làm phương án đề xuất** trong **Công cụ tính quạt HVAC** ở trang ngoài!

Tại trang thêm/sửa sản phẩm, cuộn xuống mục **Thông số kỹ thuật HVAC & Công cụ tính**:

| Tên trường thông số | Ý nghĩa | Định dạng nhập ví dụ | Tác dụng trong Công cụ tính |
|---|---|---|---|
| **Lưu lượng gió (Airflow)** | Lưu lượng gió của quạt ($m^3/h$) | `44500` (chỉ nhập số nguyên) | Dùng để tính toán số lượng quạt cần lắp bù đủ thể tích xưởng. |
| **Công suất (Power)** | Công suất điện tiêu thụ | `1.1 kW` hoặc `250W` | Hiển thị trong bảng thông số kỹ thuật và báo giá. |
| **Điện áp (Voltage)** | Nguồn điện sử dụng | `380V` hoặc `220V` hoặc `220V/380V` | Cho phép lọc theo nguồn điện 1 pha hoặc 3 pha. |
| **Kích thước (Size display)** | Kích thước phủ bì thân quạt | `1380x1380x400 mm` | Hiển thị kích thước thực tế cho kỹ thuật thi công. |
| **Kích thước lỗ chờ (Hole size)** | Kích thước ô chừa trên tường/kính | `1380x1380 mm` | Hỗ trợ thợ cơ khí cắt vách chuẩn xác. |
| **Loại quạt (Fan type)** | Phân loại kỹ thuật | `Quạt thông gió vuông`, `Quạt ly tâm`,... | Dùng để lọc theo kiểu quạt trong công cụ. |
| **Dùng cho Thông gió (Use Ventilation)** | Có dùng hút gió không | Tích chọn `Có` | Xuất hiện trong Tab 1 và Tab 3 của Công cụ tính. |
| **Dùng cho Cooling Pad** | Có dùng kết hợp làm mát không | Tích chọn `Có` | Xuất hiện trong Tab 2 (Cooling Pad) của Công cụ tính. |
| **Bảng so sánh model** | Gán ma trận model cùng dòng | Chọn bảng đã tạo (xem Chương 4) | Tự động hiển thị bảng ma trận ở trang chi tiết sản phẩm. |

---

### 3.3. Quản lý Danh mục sản phẩm (Cấp 1, Cấp 2, Cấp 3)

**Mục tiêu:** Xây dựng cây danh mục chuẩn để khách hàng dễ dàng tìm kiếm và hỗ trợ SEO URL thân thiện.

**Hệ thống phân cấp URL tự động:**
* **Cấp 1 & 2:** `/vi/quat-cong-nghiep`, `/vi/quat-thong-gio-cong-nghiep`
* **Cấp 3 tự động (Danh mục kết hợp Thương hiệu):** `/vi/quat-thong-gio-cong-nghiep-komasu`

**Các bước thêm danh mục:**
1. Vào **Sản phẩm** $\rightarrow$ chọn **Danh mục sản phẩm**.
2. Bấm nút **Thêm danh mục**.
3. Điền **Tên danh mục** (Ví dụ: *Quạt ly tâm*).
4. Chọn **Danh mục cha** (nếu là danh mục con; để trống nếu là danh mục Cấp 1).
5. Tải lên **Ảnh đại diện** danh mục (hiển thị trên trang chủ và menu mobile).
6. Nhập nội dung mô tả ngắn và cấu hình thẻ Meta SEO.
7. Bấm **Lưu danh mục**.

---

### 3.4. Quản lý Thương hiệu sản phẩm
1. Vào **Sản phẩm** $\rightarrow$ chọn **Thương hiệu**.
2. Danh sách đã có sẵn: *Komasu, Vinawind, Deton, Dasin, Chinghai, Hatari, Panasonic, Nedfon, Nanyoo,...*
3. Bạn có thể sửa tên, tải lại Logo thương hiệu (khuyên dùng định dạng SVG hoặc PNG trong suốt) và nhập bài giới thiệu hãng.

---

# 4. QUẢN LÝ BẢNG MA TRẬN SO SÁNH MODEL (MODEL COMPARISON TABLES)

### 4.1. Ý nghĩa và cơ chế hoạt động
Trong ngành quạt công nghiệp và thiết bị làm mát, một dòng sản phẩm thường có nhiều Model kích thước hoặc công suất khác nhau (ví dụ: dòng quạt cắt gió *Nanyoo FM-5509Z, FM-5512Z, FM-5515Z*).
Tính năng **Bảng so sánh model** giúp:
* Trình bày thông số dạng bảng ma trận khoa học, trực quan.
* Tự động đồng bộ giá bán theo thời gian thực từ sản phẩm tương ứng trong kho.
* Có nút liên kết trực tiếp giúp khách hàng bấm vào xem chi tiết hoặc đặt hàng model mong muốn.
* Hỗ trợ nhúng vào bài viết tư vấn kỹ thuật bằng mã ngắn (Shortcode).

---

### 4.2. Tạo mới một Bảng so sánh model

**Các bước thực hiện:**
1. Vào menu **Sản phẩm** $\rightarrow$ chọn **Bảng so sánh model**.
2. Bấm nút **Thêm mới**.
3. Điền các trường cấu hình chung:
   * **Tên bảng quản trị:** Tên gọi nội bộ (Ví dụ: *Bảng so sánh Quạt cắt gió Nanyoo Z-series*).
   * **Tiêu đề bảng (Hiển thị ra ngoài):** Ví dụ: *Bảng thông số kỹ thuật Quạt cắt gió Nanyoo-Z cho cửa cao dưới 5.5m*.
   * **Mô tả phụ:** Lời dẫn giải thích thêm.
   * **Danh sách cột thông số:** Hệ thống có sẵn 8 cột tiêu chuẩn (*Điện áp, Công suất, Lưu lượng gió, Vận tốc gió, Độ ồn, Số động cơ, Kích thước, Cân nặng*). Bạn có thể xóa bớt hoặc gõ thêm cột tùy ý.
4. Thêm các dòng Model (Items):
   * Bấm **+ Thêm dòng model**.
   * Ô **Tìm sản phẩm liên kết**: Gõ mã SKU hoặc tên sản phẩm để hệ thống tự gợi ý và liên kết. Khi liên kết, giá sản phẩm sẽ tự động cập nhật nếu sau này giá bán có thay đổi!
   * Nhập **Tên Model** (Ví dụ: *FM-5509Z-L/Y*).
   * Điền thông số chi tiết tương ứng với từng cột.
5. Tùy chọn hiển thị:
   * Tích chọn **Hiển thị cột giá**.
   * Tích chọn **Hiển thị nút xem/mua hàng**.
6. Bấm **Lưu bảng so sánh**.

---

### 4.3. Gán bảng so sánh vào Trang chi tiết sản phẩm
1. Mở trang sửa sản phẩm đại diện cho dòng sản phẩm đó (Ví dụ sản phẩm *Quạt cắt gió Nanyoo FM-5509Z-L/Y*).
2. Tại trường **Bảng so sánh model**, chọn bảng tương ứng từ danh sách thả xuống.
3. Bấm **Lưu sản phẩm**.
4. Ra ngoài website xem sản phẩm, bảng ma trận so sánh sẽ tự động hiển thị trang trọng ngay dưới phần mô tả thông số!

---

### 4.4. Nhúng bảng so sánh vào Bài viết tin tức bằng Shortcode

**Mục tiêu:** Khi biên tập bài viết phân tích, tư vấn kỹ thuật (ví dụ bài *"Top 5 mẫu quạt cắt gió công nghiệp tốt nhất cho siêu thị"*), bạn muốn chèn trực tiếp bảng thông số để khách hàng tham khảo.

**Cách làm:**
1. Vào **Bảng so sánh model**, nhìn vào cột **Mã nhúng (Shortcode)** của bảng cần dùng.
2. Sao chép đoạn mã ngắn dạng:
   ```text
   [bang_so_sanh id="1"]
   ```
3. Mở bài viết trong **Bài viết** $\rightarrow$ **Danh sách bài viết** $\rightarrow$ dán đoạn mã `[bang_so_sanh id="1"]` vào đúng vị trí văn bản bạn muốn hiển thị.
4. Bấm **Lưu bài viết**. Khi khách xem bài viết, đoạn mã sẽ tự động chuyển đổi thành bảng so sánh chuyên nghiệp, đẹp mắt.

---

### 4.5. Nhân bản (Duplicate) bảng so sánh mẫu
Khi bạn cần tạo một bảng so sánh mới có cấu trúc cột tương tự bảng đã có:
1. Vào danh sách **Bảng so sánh model**.
2. Tìm bảng mẫu $\rightarrow$ bấm nút **Nhân bản (Duplicate)**.
3. Hệ thống sẽ tạo ngay một bản sao; bạn chỉ cần bấm **Chỉnh sửa**, đổi tên và cập nhật lại thông số các model mới.

---

# 5. QUẢN LÝ ĐƠN HÀNG & TIẾP NHẬN BÁO GIÁ

### 5.1. Xem danh sách và lọc đơn hàng
1. Vào menu **Đơn hàng**.
2. Danh sách hiển thị đầy đủ: Mã đơn hàng (Ví dụ: `WL-2609-8472`), Tên khách hàng, Số điện thoại, Tổng tiền, Trạng thái đơn, Trạng thái thanh toán và Ngày tạo.
3. Có thể lọc nhanh theo:
   * Trạng thái đơn: *Chờ xử lý, Đang xử lý, Đang giao hàng, Đã hoàn thành, Đã hủy*.
   * Khoảng thời gian đặt hàng.
   * Tìm kiếm theo Mã đơn hoặc Số điện thoại người mua.

---

### 5.2. Xử lý quy trình trạng thái đơn hàng

**Quy trình chuẩn khuyến nghị:**
$$\text{Chờ xử lý (Pending)} \xrightarrow{\text{Xác nhận với khách}} \text{Đang xử lý (Processing)} \xrightarrow{\text{Gửi kho vận}} \text{Đang giao hàng (Shipping)} \xrightarrow{\text{Khách nhận hàng & thanh toán}} \text{Hoàn thành (Completed)}$$

**Các bước thao tác trong chi tiết đơn hàng:**
1. Nhấp vào **Mã đơn hàng** để mở trang chi tiết.
2. Kiểm tra danh sách sản phẩm, số lượng, địa chỉ giao hàng và ghi chú của khách.
3. Tại khung **Cập nhật trạng thái**:
   * Chọn trạng thái tiếp theo phù hợp.
   * Nhập ghi chú xử lý nội bộ (nếu cần).
4. Bấm **Cập nhật trạng thái**.

> [!CAUTION]
> * Chuyển sang **Đã hủy (Cancelled)**: Hệ thống sẽ tự động hoàn trả lại số lượng tồn kho của các sản phẩm trong đơn.
> * Chuyển sang **Hoàn thành (Completed)**: Đơn hàng kết thúc chu trình; khách hàng đủ điều kiện để viết đánh giá sản phẩm.

---

### 5.3. In phiếu đơn hàng / Phiếu đóng gói
* Tại màn hình chi tiết đơn hàng, bấm nút **In phiếu giao hàng** ở góc trên.
* Trình duyệt sẽ mở giao diện in khổ A4 chuẩn, chứa logo Winline, thông tin người gửi, thông tin người nhận, danh sách thiết bị và chữ ký người giao nhận.

---

### 5.4. Tiếp nhận thông tin Liên hệ & Yêu cầu báo giá (RFQ)

**Nguồn phát sinh:**
1. Khách gửi qua trang **Liên hệ** (`/vi/lien-he`).
2. Khách bấm nút **Yêu cầu báo giá** trên từng sản phẩm.
3. Khách lưu bản tính từ **Công cụ tính quạt HVAC** và bấm gửi thông tin báo giá.

**Cách quản lý:**
1. Vào menu **Liên hệ (Contact Submissions)**.
2. Đọc nội dung: Tên khách hàng, Công ty, Mã số thuế, Số điện thoại, Nội dung yêu cầu hoặc Mã bản dự tính đính kèm.
3. Bấm nút **Đánh dấu đã xử lý** sau khi nhân viên kinh doanh đã liên hệ chăm sóc khách hàng.

---

# 6. QUẢN LÝ NỘI DUNG MARKETING & CMS (TIN TỨC, TRANG TĨNH, BANNER)

### 6.1. Đăng bài viết tin tức / Dự án / Giải pháp kỹ thuật
1. Vào **Bài viết** $\rightarrow$ chọn **Danh sách bài viết**.
2. Bấm **Thêm bài viết mới**.
3. Nhập:
   * **Tiêu đề bài viết:** Thu hút, rõ ràng (Ví dụ: *Giải pháp thông gió làm mát áp suất âm cho nhà xưởng may 3.000m²*).
   * **Chuyên mục:** Chọn *Tin tức*, *Giải pháp HVAC* hoặc *Dự án tiêu biểu*.
   * **Ảnh đại diện:** Tải ảnh chất lượng cao (tỉ lệ khuyên dùng 16:9).
   * **Nội dung:** Soạn thảo bằng trình biên tập phong phú, chèn ảnh thực tế thi công, bảng biểu hoặc mã shortcode bảng so sánh model.
4. Bấm **Đăng bài viết**.

---

### 6.2. Tối ưu SEO cho bài viết với bộ chấm điểm chuẩn
Hệ thống tích hợp công cụ phân tích SEO tự động `PostSeoAnalyzer`:
* Điền **Thẻ tiêu đề SEO (Meta Title)**: Từ 50 - 65 ký tự.
* Điền **Thẻ mô tả SEO (Meta Description)**: Từ 130 - 160 ký tự, tóm tắt nội dung hấp dẫn để tăng tỷ lệ click trên Google.
* Điền **Từ khóa chính (Focus Keyword)**: Ví dụ *quạt thông gió nhà xưởng*.
* Quan sát thang điểm đánh giá (Xanh lá = Tốt, Vàng = Cần cải thiện, Đỏ = Chưa đạt) để điều chỉnh độ dài bài viết và mật độ từ khóa tối ưu nhất trước khi xuất bản.

---

### 6.3. Quản lý Trang tĩnh (Giới thiệu, Chính sách, Hướng dẫn)
1. Vào menu **Trang tĩnh (Pages)**.
2. Danh sách các trang chuẩn: *Giới thiệu, Chính sách bảo hành, Chính sách đổi trả, Chính sách bảo mật, Hướng dẫn mua hàng*.
3. Bấm **Chỉnh sửa** trang cần cập nhật nội dung văn bản.
4. Bấm **Lưu trang**.

---

### 6.4. Quản lý Banner Slider trang chủ
1. Vào menu **Banner**.
2. Bấm **Thêm Banner mới**.
3. Điền thông tin:
   * **Tiêu đề banner:** Đặt tên gợi nhớ chiến dịch.
   * **Vị trí:** Chọn *Slider trang chủ* hoặc *Banner danh mục*.
   * **Ảnh máy tính (Desktop):** Kích thước chuẩn `1920 x 600 px`.
   * **Ảnh điện thoại (Mobile):** Kích thước chuẩn `800 x 600 px` (đảm bảo không bị co rúm chữ khi xem trên điện thoại).
   * **Liên kết:** Dán đường dẫn khi khách click vào banner (Ví dụ: `/vi/cong-cu-tinh-quat` hoặc `/vi/san-pham`).
   * **Thứ tự sắp xếp:** Số nhỏ hiển thị trước.
4. Bấm **Lưu Banner**.

---

### 6.5. Cấu hình Menu điều hướng Storefront
1. Vào menu **Menu điều hướng**.
2. Chọn Menu cần chỉnh sửa (thường là `Primary Navigation` - Menu chính trên đầu website).
3. Thêm mới mục menu:
   * Chọn Loại đích: *Danh mục sản phẩm, Trang tĩnh, Chuyên mục tin tức, hoặc Đường dẫn URL tự nhập*.
   * Đặt tên hiển thị.
4. Kéo - thả các thanh mục menu lên/xuống để đổi thứ tự, hoặc kéo thụt vào trong để tạo menu cấp 2 (Dropdown).
5. Bấm **Lưu cấu trúc Menu**.

---

# 7. CHƯƠNG TRÌNH KHUYẾN MÃI & MÃ GIẢM GIÁ (VOUCHER)

### 7.1. Tạo mã giảm giá (Voucher)
1. Vào **Khuyến mãi** $\rightarrow$ chọn **Mã giảm giá (Vouchers)** $\rightarrow$ Bấm **Thêm mới**.
2. Điền thông tin:
   * **Mã voucher:** Chữ hoa viết liền không dấu (Ví dụ: `WINLINE50K`, `TRIANHE2026`).
   * **Loại giảm giá:** Theo số tiền cố định (VNĐ) hoặc theo phần trăm (%).
   * **Giá trị giảm:** Ví dụ `50000` hoặc `10` (%).
   * **Đơn hàng tối thiểu:** Điều kiện tổng tiền hàng để được áp mã (Ví dụ: từ `1.000.000 đ`).
   * **Số lần dùng tối đa:** Tổng số lượt áp dụng trên toàn website.
   * **Giới hạn mỗi khách hàng:** Thường đặt là `1` lần/khách.
   * **Thời hạn hiệu lực:** Chọn Ngày bắt đầu và Ngày kết thúc.
3. Bấm **Lưu voucher**.

---

# 8. CẤU HÌNH HỆ THỐNG (SETTINGS)

### 8.1. Thông tin chung website (Hotline, Email, Địa chỉ, Logo)
1. Vào menu **Cấu hình** $\rightarrow$ chọn **Cấu hình chung**.
2. Cập nhật thông tin công ty:
   * **Tên công ty / Cửa hàng:** Winline Việt Nam.
   * **Hotline bán hàng:** `0949.761.888` / `0243.683.0735`.
   * **Email liên hệ:** `winlinevietnam@gmail.com`.
   * **Địa chỉ trụ sở / Kho hàng:** Nhập địa chỉ hiển thị ở chân trang.
   * **Mã nhúng đo lường:** Chèn mã Google Tag Manager, Google Analytics 4 (GA4), Facebook Pixel hoặc mã chat Zalo/Tawk.to.
3. Bấm **Lưu cấu hình**.

---

### 8.2. Cấu hình cổng thanh toán (Payment Methods)
Vào **Cấu hình** $\rightarrow$ **Cấu hình thanh toán**:
1. **Thanh toán khi nhận hàng (COD):** Bật/tắt phương thức nhận hàng thanh toán tiền mặt.
2. **Chuyển khoản ngân hàng (VietQR / SePay):**
   * Nhập Tên ngân hàng, Số tài khoản, Tên chủ tài khoản.
   * Hệ thống tự động sinh mã VietQR có sẵn số tiền và nội dung chuyển khoản theo mã đơn hàng.
3. **Cổng VNPAY (Thẻ ATM nội địa, Visa/MasterCard, VNPAY-QR):**
   * Nhập `TMN Code` và `Hash Secret` do VNPAY cung cấp khi ký hợp đồng.

---

### 8.3. Cấu hình Email gửi tự động (SMTP)
Vào **Cấu hình** $\rightarrow$ **Cấu hình thông báo (Notification Settings)**:
* Nhập cấu hình máy chủ gửi thư (Google Workspace hoặc Mail công ty Mắt Bão):
  * **Mail Host:** `smtp.gmail.com`
  * **Mail Port:** `587` (hoặc `465`)
  * **Tên đăng nhập:** Email công ty dùng để gửi.
  * **Mật khẩu ứng dụng (App Password):** Mật khẩu riêng cho dịch vụ gửi mail.
* Bấm **Gửi email thử nghiệm (Test Email)** để chắc chắn hệ thống hoạt động ổn định trước khi đưa vào vận hành.

---

# 9. BẢNG TRA CỨU & TIÊU CHUẨN DỮ LIỆU (REFERENCE)

### 9.1. Quy chuẩn kích thước hình ảnh tối ưu

Để website tải nhanh, mượt mà và không làm tràn bộ nhớ hosting, hình ảnh tải lên nên được nén trước (qua tinypng.com) và tuân theo bảng kích thước sau:

| Vị trí hình ảnh | Kích thước khuyến nghị | Tỷ lệ khung hình | Định dạng tốt nhất |
|---|---|---|---|
| **Ảnh đại diện sản phẩm** | $800 \times 800\text{ px}$ | $1:1$ (Vuông) | JPG, WebP |
| **Ảnh slider máy tính (Desktop)** | $1920 \times 600\text{ px}$ | $16:5$ | JPG, WebP |
| **Ảnh slider điện thoại (Mobile)** | $800 \times 600\text{ px}$ | $4:3$ | JPG, WebP |
| **Logo thương hiệu hãng quạt** | $300 \times 150\text{ px}$ | $2:1$ | SVG, PNG (nền trong suốt) |
| **Ảnh đại diện bài viết tin tức** | $1200 \times 675\text{ px}$ | $16:9$ | JPG, WebP |
| **Icon / Favicon trình duyệt** | $512 \times 512\text{ px}$ | $1:1$ | PNG |

---

### 9.2. Bảng ý nghĩa các trạng thái đơn hàng

| Mã trạng thái | Tên hiển thị | Ý nghĩa nghiệp vụ |
|---|---|---|
| `pending` | **Chờ xác nhận** | Đơn hàng mới đặt trên website, chưa có nhân viên liên hệ xác thực. |
| `processing` | **Đang xử lý** | Nhân viên đã gọi điện chốt đơn, kho đang xuất hàng đóng gói. |
| `shipping` | **Đang giao hàng** | Hàng đã bàn giao cho tài xế hoặc đơn vị vận chuyển (GHTK/ViettelPost). |
| `completed` | **Đã hoàn thành** | Khách đã nhận hàng thành công và thanh toán đủ. |
| `cancelled` | **Đã hủy** | Đơn bị hủy do khách đổi ý hoặc hết hàng. Tồn kho tự động hoàn lại. |

---

# 10. HỎI ĐÁP & XỬ LÝ SỰ CỐ THƯỜNG GẶP (TROUBLESHOOTING & FAQ)

### Q1: Tôi quên mật khẩu đăng nhập trang admin thì phải làm sao?
* **Cách xử lý:** Nhờ một quản trị viên khác có quyền **Super Admin** vào màn hình *Quản lý người dùng*, tìm tài khoản của bạn và gõ mật khẩu mới vào ô *Mật khẩu mới* rồi bấm Lưu.

### Q2: Tại sao tôi thêm sản phẩm quạt mới nhưng không thấy hiện trong "Công cụ tính quạt"?
* **Nguyên nhân:** Sản phẩm chưa được điền trường **Lưu lượng gió (Airflow)** hoặc chưa tích chọn **Dùng cho Thông gió (Use Ventilation)**.
* **Cách xử lý:** Mở lại sản phẩm $\rightarrow$ cuộn xuống mục *Thông số kỹ thuật HVAC* $\rightarrow$ nhập số lưu lượng gió ($m^3/h$) $\rightarrow$ tích chọn ô *Dùng cho thông gió* $\rightarrow$ Bấm Lưu.

### Q3: Khách đặt hàng xong nhưng công ty không nhận được email thông báo đơn mới?
* **Cách xử lý:** 
  1. Kiểm tra hòm thư rác (Spam) của email người nhận.
  2. Vào *Cấu hình* $\rightarrow$ *Cấu hình thông báo*, bấm nút *Gửi email thử nghiệm*. Nếu báo lỗi, hãy kiểm tra lại Mật khẩu ứng dụng (App Password) của tài khoản Gmail/SMTP.

### Q4: Tôi thay đổi Banner nhưng ra trang chủ vẫn thấy banner cũ?
* **Cách xử lý:** Trình duyệt của bạn đang lưu bộ nhớ đệm (Cache). Hãy nhấn tổ hợp phím `Ctrl + F5` (hoặc `Cmd + Shift + R` trên máy Mac) để tải lại trang trắng bộ nhớ đệm.

---
*Tài liệu này được biên soạn bởi Mắt Bão WS dành riêng cho Công ty TNHH Winline Việt Nam.*  
*Mọi thắc mắc kỹ thuật trong quá trình vận hành, vui lòng liên hệ đội ngũ kỹ thuật Mắt Bão để được hỗ trợ.*
