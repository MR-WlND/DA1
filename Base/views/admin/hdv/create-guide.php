<?php include PATH_VIEW . 'layout/header.php'; ?>

<div class="main">
    <div class="container-fluid">
        <h2 class="mb-4">Thêm Hướng dẫn viên mới</h2>

        <form action="<?= BASE_URL ?>?action=create-guide" method="post" enctype="multipart/form-data">
            
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-primary border-bottom pb-2">1. Thông tin tài khoản</h4>
                    
                    <div class="form-group mt-3">
                        <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ví dụ: Nguyễn Văn A" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="email" class="form-label">Email đăng nhập <span class="text-danger">*</span>:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span>:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="photo_url" class="form-label">Ảnh đại diện:</label>
                        <input type="file" class="form-control" id="photo_url" name="photo_url">
                    </div>
                </div>

                <div class="col-md-6">
                    <h4 class="text-success border-bottom pb-2">2. Hồ sơ chuyên môn</h4>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phân loại:</label>
                                <select class="form-control form-select" name="category">
                                    <option value="domestic">Nội địa (Domestic)</option>
                                    <option value="international">Quốc tế (International)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nhóm chuyên môn:</label>
                                <select class="form-control form-select" name="specialty_group">
                                    <option value="standard">Tiêu chuẩn (Standard)</option>
                                    <option value="vip">VIP</option>
                                    <option value="corporate">Doanh nghiệp</option>
                                    <option value="leisure">Nghỉ dưỡng</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Tuyến điểm sở trường:</label>
                        <input type="text" class="form-control" name="specialty_route" placeholder="VD: Đông Bắc, Đà Nẵng, Thái Lan...">
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Ngôn ngữ thành thạo:</label>
                                <input type="text" class="form-control" name="languages" placeholder="VD: Anh, Pháp, Trung">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Kinh nghiệm (năm):</label>
                                <input type="number" class="form-control" name="experience_years" min="0" value="0">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Ngày sinh:</label>
                        <input type="date" class="form-control" name="date_of_birth">
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <h4 class="text-info border-bottom pb-2">3. Thông tin bổ sung</h4>
                </div>
                
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label class="form-label">Chứng chỉ / Thẻ HDV:</label>
                        <textarea class="form-control" name="certification" rows="3" placeholder="Chi tiết về thẻ hướng dẫn viên, chứng chỉ ngoại ngữ..."></textarea>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label class="form-label">Tình trạng sức khỏe:</label>
                        <textarea class="form-control" name="health_status" rows="3" placeholder="Tốt, có tiền sử bệnh gì không..."></textarea>
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label class="form-label">Ghi chú khác:</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                </div>
            </div>

            <div class="mt-4 mb-5">
                <button type="submit" class="btn btn-nut btn-lg">Thêm mới HDV</button>
                <a href="<?= BASE_URL ?>?action=list-guide" class="btn btn-danger btn-lg ms-2">Quay lại</a>
            </div>

        </form>
    </div>
</div>

<?php include PATH_VIEW . 'layout/footer.php'; ?>