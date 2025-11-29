<?php
class BookingController
{
    private $bookingModel;
    private $userModel;
    private $roomModel;

    public function __construct()
    {
        $this->bookingModel = new BookingModel();
        $this->userModel = new UserModel();
        $this->roomModel = new RoomModel();
    }

    // List booking
    public function index()
    {
        $bookings = $this->bookingModel->all();
        include_once "views/booking/index.php";
    }

    // Form tạo
    public function create()
    {
        $users = $this->userModel->all();
        $rooms = $this->roomModel->all();
        include_once "views/booking/create.php";
    }

    // Lưu booking
    public function store()
    {
        $data = [
            'user_id'     => $_POST['user_id'],
            'room_id'     => $_POST['room_id'],
            'start_date'  => $_POST['start_date'],
            'end_date'    => $_POST['end_date'],
            'total_price' => $_POST['total_price']
        ];

        $this->bookingModel->insert($data);
        header("Location: /booking");
        exit;
    }

    // Form sửa
    public function edit($id)
    {
        $booking = $this->bookingModel->find($id);
        $users = $this->userModel->all();
        $rooms = $this->roomModel->all();

        include_once "views/booking/edit.php";
    }

    // Update booking
    public function update($id)
    {
        $data = [
            'user_id'     => $_POST['user_id'],
            'room_id'     => $_POST['room_id'],
            'start_date'  => $_POST['start_date'],
            'end_date'    => $_POST['end_date'],
            'total_price' => $_POST['total_price']
        ];

        $this->bookingModel->update($id, $data);

        header("Location: /booking");
        exit;
    }

    // Xóa
    public function delete($id)
    {
        $this->bookingModel->delete($id);
        header("Location: /booking");
        exit;
    }
}
