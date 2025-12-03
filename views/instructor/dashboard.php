<?php include 'views/layouts/header.php'; ?>

<style>
    .instructor-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 0;
        margin-bottom: 40px;
        border-radius: 10px;
    }

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .stats-card .icon {
        font-size: 32px;
        margin-bottom: 15px;
    }

    .stats-card h3 {
        font-weight: bold;
        font-size: 32px;
        margin: 10px 0;
        color: #333;
    }

    .stats-card p {
        color: #999;
        margin: 0;
        font-size: 14px;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-bottom: none;
    }

    .table-header h5 {
        margin: 0;
        font-weight: bold;
    }

    .btn-create {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .course-row {
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .course-row:hover {
        background: #f8f9fa;
    }

    .course-row td {
        vertical-align: middle;
        padding: 15px;
    }

    .course-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }

    .course-level {
        font-size: 12px;
    }

    .course-description {
        color: #999;
        font-size: 13px;
        margin: 0;
    }

    .course-price {
        color: #f5576c;
        font-weight: bold;
        font-size: 15px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .action-btn {
        padding: 6px 12px;
        border-radius: 6px;
        border: none;
        font-size: 13px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-view-students {
        background: #e3f2fd;
        color: #1976d2;
    }

    .btn-view-students:hover {
        background: #1976d2;
        color: white;
    }

    .btn-manage-lessons {
        background: #f3e5f5;
        color: #7b1fa2;
    }

    .btn-manage-lessons:hover {
        background: #7b1fa2;
        color: white;
    }

    .btn-edit {
        background: #fff3e0;
        color: #e65100;
    }

    .btn-edit:hover {
        background: #e65100;
        color: white;
    }

    .btn-delete {
        background: #ffebee;
        color: #c62828;
    }

    .btn-delete:hover {
        background: #c62828;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .pagination {
        padding: 20px;
        border-top: 1px solid #e0e0e0;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #764ba2;
    }

    .filter-section {
        background: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .badge-level {
        font-size: 11px;
        padding: 5px 10px;
    }
</style>

<!-- Instructor Header -->
<div class="instructor-header">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="mb-2"><i class="fas fa-chalkboard-teacher me-3"></i>Bảng điều khiển Giảng viên</h1>
            <p class="mb-0 opacity-75">Quản lý khóa học, bài giảng và theo dõi học viên của bạn</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="index.php?controller=instructor&action=create" class="btn btn-create">
                <i class="fas fa-plus-circle me-2"></i>Tạo khóa học mới
            </a>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stats-card">
            <div class="icon text-primary">
                <i class="fas fa-book"></i>
            </div>
            <h3>8</h3>
            <p>Tổng số khóa học</p>
        </div>
    </div>
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stats-card">
            <div class="icon text-success">
                <i class="fas fa-users"></i>
            </div>
            <h3>156</h3>
            <p>Tổng học viên đăng ký</p>
        </div>
    </div>
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="stats-card">
            <div class="icon text-warning">
                <i class="fas fa-money-bill"></i>
            </div>
            <h3>18.5M</h3>
            <p>Doanh thu ước tính</p>
        </div>
    </div>
</div>

<!-- Courses Management Table -->
<div class="table-container">
    <!-- Header -->
    <div class="table-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Danh sách khóa học của tôi</h5>
        <span class="badge bg-light text-dark">8 khóa học</span>
    </div>

    <!-- Filters -->
    <div class="filter-section" style="margin: 0; border-radius: 0; box-shadow: none; border-bottom: 1px solid #e0e0e0;">
        <div class="row gap-2">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Tìm kiếm tên khóa học...">
            </div>
            <div class="col-md-4">
                <select class="form-select">
                    <option>Tất cả trạng thái</option>
                    <option>Đang bán</option>
                    <option>Hết hạn</option>
                    <option>Bản nháp</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option>Sắp xếp</option>
                    <option>Mới nhất</option>
                    <option>Cũ nhất</option>
                    <option>Giá cao đến thấp</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="bg-light">
                <tr>
                    <th width="5%" class="text-center">#</th>
                    <th width="25%">Tên khóa học</th>
                    <th width="30%">Mô tả</th>
                    <th width="10%" class="text-center">Giá</th>
                    <th width="12%" class="text-center">Học viên</th>
                    <th width="18%" class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <!-- Course 1 -->
                <tr class="course-row">
                    <td class="text-center fw-bold">1</td>
                    <td>
                        <div class="course-name">Lập trình PHP MVC nâng cao</div>
                        <span class="badge badge-level bg-warning text-dark">Nâng cao</span>
                    </td>
                    <td>
                        <p class="course-description">Khóa học chuyên sâu về mô hình MVC, bảo mật và tối ưu hóa website...</p>
                    </td>
                    <td class="text-center">
                        <span class="course-price">1,200,000 đ</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">25 người</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn btn-view-students" title="Xem danh sách học viên">
                                <i class="fas fa-users"></i> DS HV
                            </button>
                            <button class="action-btn btn-manage-lessons" title="Quản lý bài giảng">
                                <i class="fas fa-book"></i> Bài
                            </button>
                            <button class="action-btn btn-edit" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Course 2 -->
                <tr class="course-row">
                    <td class="text-center fw-bold">2</td>
                    <td>
                        <div class="course-name">JavaScript Nâng cao</div>
                        <span class="badge badge-level bg-info text-white">Trung bình</span>
                    </td>
                    <td>
                        <p class="course-description">Học async/await, Promises, DOM API, và các pattern JavaScript hiện đại...</p>
                    </td>
                    <td class="text-center">
                        <span class="course-price">950,000 đ</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">18 người</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn btn-view-students" title="Xem danh sách học viên">
                                <i class="fas fa-users"></i> DS HV
                            </button>
                            <button class="action-btn btn-manage-lessons" title="Quản lý bài giảng">
                                <i class="fas fa-book"></i> Bài
                            </button>
                            <button class="action-btn btn-edit" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Course 3 -->
                <tr class="course-row">
                    <td class="text-center fw-bold">3</td>
                    <td>
                        <div class="course-name">React.js Từ Cơ Bản Đến Nâng Cao</div>
                        <span class="badge badge-level bg-warning text-dark">Nâng cao</span>
                    </td>
                    <td>
                        <p class="course-description">Khóa học React.js tổng hợp: component, hooks, state management, routing...</p>
                    </td>
                    <td class="text-center">
                        <span class="course-price">1,500,000 đ</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">42 người</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn btn-view-students" title="Xem danh sách học viên">
                                <i class="fas fa-users"></i> DS HV
                            </button>
                            <button class="action-btn btn-manage-lessons" title="Quản lý bài giảng">
                                <i class="fas fa-book"></i> Bài
                            </button>
                            <button class="action-btn btn-edit" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Course 4 -->
                <tr class="course-row">
                    <td class="text-center fw-bold">4</td>
                    <td>
                        <div class="course-name">Python cho Lập Trình Viên</div>
                        <span class="badge badge-level bg-success text-white">Cơ bản</span>
                    </td>
                    <td>
                        <p class="course-description">Python cho người mới bắt đầu: syntax, data structures, OOP...</p>
                    </td>
                    <td class="text-center">
                        <span class="course-price">750,000 đ</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">35 người</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn btn-view-students" title="Xem danh sách học viên">
                                <i class="fas fa-users"></i> DS HV
                            </button>
                            <button class="action-btn btn-manage-lessons" title="Quản lý bài giảng">
                                <i class="fas fa-book"></i> Bài
                            </button>
                            <button class="action-btn btn-edit" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Course 5 -->
                <tr class="course-row">
                    <td class="text-center fw-bold">5</td>
                    <td>
                        <div class="course-name">Node.js API Development</div>
                        <span class="badge badge-level bg-info text-white">Trung bình</span>
                    </td>
                    <td>
                        <p class="course-description">Xây dựng RESTful API với Node.js, Express, MongoDB...</p>
                    </td>
                    <td class="text-center">
                        <span class="course-price">1,050,000 đ</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">20 người</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn btn-view-students" title="Xem danh sách học viên">
                                <i class="fas fa-users"></i> DS HV
                            </button>
                            <button class="action-btn btn-manage-lessons" title="Quản lý bài giảng">
                                <i class="fas fa-book"></i> Bài
                            </button>
                            <button class="action-btn btn-edit" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Course 6 -->
                <tr class="course-row">
                    <td class="text-center fw-bold">6</td>
                    <td>
                        <div class="course-name">Vue.js Master Class</div>
                        <span class="badge badge-level bg-warning text-dark">Nâng cao</span>
                    </td>
                    <td>
                        <p class="course-description">Thành thạo Vue.js 3: Composition API, Pinia, Router...</p>
                    </td>
                    <td class="text-center">
                        <span class="course-price">920,000 đ</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">16 người</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn btn-view-students" title="Xem danh sách học viên">
                                <i class="fas fa-users"></i> DS HV
                            </button>
                            <button class="action-btn btn-manage-lessons" title="Quản lý bài giảng">
                                <i class="fas fa-book"></i> Bài
                            </button>
                            <button class="action-btn btn-edit" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Course 7 -->
                <tr class="course-row">
                    <td class="text-center fw-bold">7</td>
                    <td>
                        <div class="course-name">Thiết Kế Web Responsive</div>
                        <span class="badge badge-level bg-success text-white">Cơ bản</span>
                    </td>
                    <td>
                        <p class="course-description">Học HTML, CSS, Bootstrap để tạo web responsive đẹp mắt...</p>
                    </td>
                    <td class="text-center">
                        <span class="course-price">650,000 đ</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success">28 người</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn btn-view-students" title="Xem danh sách học viên">
                                <i class="fas fa-users"></i> DS HV
                            </button>
                            <button class="action-btn btn-manage-lessons" title="Quản lý bài giảng">
                                <i class="fas fa-book"></i> Bài
                            </button>
                            <button class="action-btn btn-edit" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Course 8 -->
                <tr class="course-row">
                    <td class="text-center fw-bold">8</td>
                    <td>
                        <div class="course-name">Digital Marketing Toàn Diện</div>
                        <span class="badge badge-level bg-info text-white">Trung bình</span>
                    </td>
                    <td>
                        <p class="course-description">SEO, SEM, Social Media Marketing, Email Marketing...</p>
                    </td>
                    <td class="text-center">
                        <span class="course-price">580,000 đ</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-warning text-dark">12 người</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-btn btn-view-students" title="Xem danh sách học viên">
                                <i class="fas fa-users"></i> DS HV
                            </button>
                            <button class="action-btn btn-manage-lessons" title="Quản lý bài giảng">
                                <i class="fas fa-book"></i> Bài
                            </button>
                            <button class="action-btn btn-edit" title="Chỉnh sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="action-btn btn-delete" onclick="return confirm('Bạn chắc chắn muốn xóa?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav class="pagination" aria-label="Page navigation">
        <ul class="pagination justify-content-center mb-0">
            <li class="page-item disabled"><a class="page-link" href="#">Trước</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">Sau</a></li>
        </ul>
    </nav>
</div>

<?php include 'views/layouts/footer.php'; ?>