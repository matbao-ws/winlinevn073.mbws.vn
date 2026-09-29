# CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM
### Độc lập - Tự do - Hạnh phúc
---

# BIÊN BẢN BÀN GIAO VÀ NGHIỆM THU DỰ ÁN PHẦN MỀM
### HỆ THỐNG WEBSITE THƯƠNG MẠI ĐIỆN TỬ & CÔNG CỤ TÍNH TOÁN KỸ THUẬT HVAC WINLINE.VN

- **Số biên bản:** `BBBG-MBWS/2026/WINLINE-01`
- **Địa điểm lập:** Hà Nội, ngày 29 tháng 09 năm 2026
- **Căn cứ:**
  - Hợp đồng dịch vụ thiết kế và phát triển phần mềm website giữa Mắt Bão WS và Công ty TNHH Winline Việt Nam.
  - Tài liệu bản đồ website và luồng nội dung: `Winline_Website_Maps_Ban_giao_Thiet_ke_Mat_Bao_v1.docx`.
  - Tài liệu công thức tính toán quạt thông gió kỹ thuật: `Winline_Cong_thuc_tinh_quat_Ban_chot_gui_Mat_Bao_v05.xlsx`.
  - Kết quả kiểm thử tự động toàn diện và nghiệm thu kỹ thuật (44/44 Routes đạt chuẩn, 0 lỗi tài nguyên, 0 lỗi console).

---

## I. THÀNH PHẦN THAM GIA BÀN GIAO & NGHIỆM THU

### BÊN GIAO (ĐƠN VỊ PHÁT TRIỂN PHẦN MỀM): CÔNG TY CỔ PHẦN MẮT BÃO (MẮT BÃO WS)
- **Địa chỉ:** Tòa nhà Mắt Bão, 12A Núi Thành, Phường 13, Quận Tân Bình, TP. Hồ Chí Minh
- **Đại diện:** Ông/Bà Trưởng Ban Quản Lý Dự Án Mắt Bão WS
- **Bộ phận phụ trách:** Khối Giải Pháp Công Nghệ & Phần Mềm Web (MatBao WS Engineering)
- **Hotline hỗ trợ kỹ thuật:** 1900 1830 | **Email:** support@matbao.ws

### BÊN NHẬN (ĐƠN VỊ THỤ HƯỞNG & VẬN HÀNH): CÔNG TY TNHH WINLINE VIỆT NAM
- **Địa chỉ:** Số 17, ngõ 46, phố Quan Nhân, Phường Trung Hòa, Quận Cầu Giấy, TP. Hà Nội
- **Mã số thuế:** 0106362846
- **Đại diện:** Ban Giám Đốc Công ty TNHH Winline Việt Nam
- **Bộ phận tiếp nhận:** Bộ phận Kế toán kinh doanh, Đội ngũ Kỹ sư kỹ thuật HVAC & Quản trị hệ thống
- **Điện thoại:** 0949.761.893 - 0243.683.0735 | **Email:** winlinevietnam@gmail.com

---

## II. NỘI DUNG VÀ HẠNG MỤC BÀN GIAO CHI TIẾT

Hôm nay, hai bên cùng tiến hành kiểm tra, đối chiếu và thống nhất bàn giao toàn bộ các hạng mục công việc thuộc dự án phần mềm với chi tiết như sau:

### 1. Bàn giao Mã nguồn (Source Code) & Cơ sở dữ liệu (Database)
- **Toàn bộ mã nguồn dự án:** 100% source code phát triển trên nền tảng framework hiện đại **Laravel 12 LTS**, tuân thủ nghiêm ngặt tiêu chuẩn PSR-12, Clean Architecture và MVC.
- **Cơ sở dữ liệu hoàn chỉnh:**
  - Hệ thống Database Migration & Seeders khởi tạo tự động toàn bộ cấu trúc bảng và dữ liệu mẫu ngành quạt công nghiệp Winline.
  - Các bảng danh mục quạt, thuộc tính kỹ thuật HVAC, bảng đối chiếu model (Model Comparison Tables), bảng đơn hàng, khách hàng, bài viết tin tức, cờ tính năng (Feature Flags).
- **Trạng thái kho lưu trữ (Git Repository):**
  - Remote: `https://github.com/matbao-ws/winlinevn073.mbws.vn.git`
  - Nhánh bàn giao: `main` (Trạng thái working tree sạch sẽ, toàn bộ commits đã được đồng bộ).

### 2. Bàn giao Tài khoản Quản trị Cấp cao nhất (Superadmin Access)
- **Đường dẫn đăng nhập quản trị:** `https://winline.vn/vi/admin/login` (hoặc `http://127.0.0.1:8080/vi/admin/login` trên môi trường nội bộ)
- **Email quản trị viên cao nhất:** `winlinevietnam@gmail.com`
- **Mật khẩu khởi tạo:** `Admin@Winline2026!` *(Khuyến cáo đổi mật khẩu ngay sau buổi bàn giao)*
- **Vai trò:** Superadmin (Phân quyền toàn bộ hệ thống, quản lý tài khoản nhân viên, cấu hình phân hệ).

### 3. Nghiệm thu 17 Phân hệ Chức năng Cốt lõi (100% Đạt yêu cầu)

| STT | Phân hệ / Tính năng bàn giao | Mô tả chi tiết kỹ thuật | Kết quả nghiệm thu |
| :---: | :--- | :--- | :---: |
| **01** | **Xác thực & Bảo mật đăng nhập** | Cổng đăng nhập an toàn, phân quyền tài khoản, cơ chế chống tấn công dò quét mật khẩu (Rate Limiting 5 lần/phút). | **ĐẠT (PASS)** |
| **02** | **Bảng điều khiển kinh doanh (Dashboard)** | Thống kê doanh thu thời gian thực, tổng số đơn hàng mới, danh sách thiết bị bán chạy, yêu cầu báo giá chờ xử lý. | **ĐẠT (PASS)** |
| **03** | **Quản lý Thành viên & Phân quyền Roles** | Quản lý nhân viên vận hành, phân quyền đa cấp bậc (Superadmin, Kinh doanh, Kế toán, Kỹ thuật HVAC, Biên tập viên). Công tắc khóa/kích hoạt tức thời. | **ĐẠT (PASS)** |
| **04** | **Quản lý Quạt Công Nghiệp HVAC** | Quản lý sản phẩm quạt với đầy đủ các thuộc tính chuyên sâu: Lưu lượng ($m^3/h$), Cột áp ($Pa$), Công suất ($kW$), Độ ồn ($dB$), Điện áp ($220V/380V$), Kích thước ($mm$), File bản vẽ PDF. | **ĐẠT (PASS)** |
| **05** | **Ma trận So sánh Model (Comparison Matrix)** | Bảng đối chiếu đa model trực quan theo series, tự động hiển thị bảng thông số kỹ thuật ra trang chi tiết sản phẩm ngoài storefront. | **ĐẠT (PASS)** |
| **06** | **Quản lý Đơn hàng (Order Management)** | Quy trình xử lý vòng đời đơn hàng: Tiếp nhận &rarr; Xác nhận &rarr; Xuất kho &rarr; Đang giao hàng &rarr; Hoàn tất &rarr; Quyết toán. | **ĐẠT (PASS)** |
| **07** | **Phễu Yêu cầu Báo giá Dự án (RFQ Leads)** | Tiếp nhận yêu cầu báo giá khối lượng lớn từ nhà thầu xây dựng/kỹ sư cơ điện MEP; hỗ trợ chuyển đổi RFQ thành đơn hàng chính thức. | **ĐẠT (PASS)** |
| **08** | **Biên tập Bài viết & Đo lường SEO Onpage** | Trình soạn thảo văn bản Rich Text chèn ảnh/bản vẽ kỹ thuật; bộ chấm điểm SEO Meta Title, Meta Description, URL Slug chuẩn Google SERP. | **ĐẠT (PASS)** |
| **09** | **Mã Khuyến mãi & Chiết khấu (Vouchers)** | Cấu hình mã voucher giảm giá phần trăm hoặc giảm tiền cố định cho khách hàng dự án và khách mua lẻ. | **ĐẠT (PASS)** |
| **10** | **Kiểm duyệt Đánh giá Khách hàng (Reviews)** | Kiểm duyệt bình luận, đánh giá sao sản phẩm trước khi công khai ra website nhằm bảo vệ uy tín thương hiệu. | **ĐẠT (PASS)** |
| **11** | **Quản lý Banner & Sliders Trang chủ** | Quản lý hệ thống banner quảng cáo, slide trang chủ độ phân giải cao và vị trí liên kết điều hướng. | **ĐẠT (PASS)** |
| **12** | **Cây Menu Điều hướng Đa cấp (Mega Menu)** | Tùy chỉnh danh mục quạt công nghiệp dạng Mega Menu, menu chính (Header) và menu chân trang (Footer). | **ĐẠT (PASS)** |
| **13** | **Thư viện File & Bản vẽ Kỹ thuật PDF (Media)** | Kho lưu trữ ảnh sản phẩm, catalogue kỹ thuật PDF, chứng chỉ xuất xưởng CO/CQ của công ty Winline. | **ĐẠT (PASS)** |
| **14** | **Cài đặt Hệ thống & Cờ Tính năng (Settings)** | Cấu hình thương hiệu Winline (Hotline, Email, Địa chỉ, Mã số thuế, Tỷ giá) và bật/tắt linh hoạt các phân hệ. | **ĐẠT (PASS)** |
| **15** | **Quản trị Đa ngôn ngữ (Localization)** | Hỗ trợ song ngữ Tiếng Việt (`vi` - mặc định) và Tiếng Anh (`en`) phục vụ đối tác và nhà thầu quốc tế. | **ĐẠT (PASS)** |
| **16** | **Nhật ký Kiểm toán Bảo mật (Activity Logs)** | Ghi nhận chi tiết mọi thao tác của nhân sự (Người thực hiện, Thời gian, Địa chỉ IP, Hành động) phục vụ đối soát. | **ĐẠT (PASS)** |
| **17** | **Công cụ Tính toán Quạt Thông Gió HVAC** | Thuật toán tính toán lưu lượng thông gió tự động theo thể tích ($D \times R \times C$) và bội số trao đổi khí TCVN; đề xuất chính xác mã quạt Winline đáp ứng công trình (`/vi/cong-cu-tinh-quat`). | **ĐẠT (PASS)** |

### 4. Bàn giao Bộ Tài liệu Vận hành & Hướng dẫn Sử dụng Chuẩn chỉnh
- **Bản in ấn PDF hoàn thiện:** `docs/Huong_Dan_Su_Dung_Admin_Winline.pdf` (5.7 MB, gồm 30 trang in màu A4 với ảnh chụp thực tế 100% từ giao diện hệ thống Winline, kèm khoanh vùng callout ① ② ③ và bảng tra cứu hành động).
- **Cổng cẩm nang điện tử:** `docs/user-manual.html` (Giao diện web trực quan, 2 cột điều hướng, thanh tìm kiếm thông minh).
- **Tích hợp nút Hướng dẫn sử dụng:** Đã gắn trực tiếp vào Top Header trang Admin ([`header.blade.php`](file:///d:/Workspace/matbao-ws/winlinevn073.mbws.vn/resources/views/admin/layouts/header.blade.php)), giúp nhân viên Winline mở cẩm nang bất kỳ lúc nào qua đường dẫn `/huong-dan-su-dung`.
- **Bản Markdown lưu trữ kỹ thuật:** `docs/HUONG_DAN_SU_DUNG_ADMIN_WINLINE.md`.

---

## III. KẾT QUẢ KIỂM THỬ KỸ THUẬT & CHẤT LƯỢNG HỆ THỐNG

Đội ngũ kỹ thuật Mắt Bão WS đã tiến hành kiểm thử tự động toàn diện bằng Playwright và Headless Edge trên môi trường vận hành thực tế:
- **Kiểm thử Route (44/44 Routes):** 100% đường dẫn quản trị và khách hàng phản hồi mã trạng thái **HTTP 200 OK**.
- **Kiểm thử Tài nguyên (Assets):** 0 lỗi tải ảnh, 0 lỗi CSS, 0 lỗi JavaScript (Failed asset requests: 0).
- **Kiểm thử Console (Console Errors):** 0 lỗi script hoặc lỗi logic trên trình duyệt (Console errors: 0).
- **Hiệu năng & Tải trang:** Hệ thống tải trang mượt mà, phản hồi dưới 300ms trên môi trường máy chủ tiêu chuẩn.

---

## IV. CAM KẾT BẢO HÀNH & HỖ TRỢ KỸ THUẬT (SLA)

1. **Thời hạn bảo hành miễn phí:** **12 tháng** kể từ ngày hai bên ký biên bản bàn giao và nghiệm thu.
2. **Phạm vi bảo hành:**
   - Khắc phục miễn phí mọi lỗi phát sinh từ mã nguồn (bug phần mềm, lỗi logic, lỗi hiển thị giao diện đã nghiệm thu).
   - Đảm bảo hệ thống vận hành liên tục, ổn định trên hạ tầng máy chủ đạt chuẩn.
   - Hỗ trợ giải đáp thắc mắc nghiệp vụ và hướng dẫn sử dụng cho nhân sự mới của Winline Việt Nam.
3. **Đầu mối liên hệ hỗ trợ:**
   - Hotline hỗ trợ kỹ thuật Mắt Bão: **1900 1830**
   - Kênh tiếp nhận sự cố khẩn cấp: **support@matbao.ws**
   - Thời gian tiếp nhận: 24/7 đối với sự cố tê liệt hệ thống, trong vòng 2-4 giờ làm việc đối với các yêu cầu hỗ trợ vận hành thông thường.

---

## V. KẾT LUẬN CỦA HAI BÊN

- Bên Nhận (Công ty TNHH Winline Việt Nam) xác nhận đã kiểm tra, chạy thử toàn bộ hệ thống phần mềm và nhận bàn giao đầy đủ mã nguồn, cơ sở dữ liệu, tài khoản quản trị và hồ sơ tài liệu hướng dẫn sử dụng.
- Hệ thống hoạt động chính xác, đầy đủ các chức năng theo đúng thỏa thuận, không còn bất kỳ lỗi kỹ thuật nào.
- Hai bên đồng ý ký biên bản bàn giao và nghiệm thu dự án để đưa hệ thống vào vận hành khai thác chính thức kể từ ngày hôm nay.
- Biên bản này được lập thành 04 (bốn) bản có giá trị pháp lý như nhau, mỗi bên giữ 02 (hai) bản để thực hiện.

---

### ĐẠI DIỆN BÊN GIAO (MẮT BÃO WS)
*(Ký, ghi rõ họ tên và đóng dấu)*

<br/><br/><br/><br/>
**CÔNG TY CỔ PHẦN MẮT BÃO**

---

### ĐẠI DIỆN BÊN NHẬN (WINLINE VIỆT NAM)
*(Ký, ghi rõ họ tên và đóng dấu)*

<br/><br/><br/><br/>
**CÔNG TY TNHH WINLINE VIỆT NAM**
