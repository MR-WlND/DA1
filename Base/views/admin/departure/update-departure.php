<form action="<?= BASE_URL ?>?action=update-departure&id=<?= $data['id'] ?>" method="post">
    <div class="mb-3">
        <label for="">Tour</label>
        <select name="tour_id" class="form-control">
            <?php foreach ($listTour as $tour): ?>
                <option value="<?= $tour['id'] ?>" <?= $data['tour_id'] == $tour['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tour['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="">Start Date</label>
        <input type="date" class="form-control" name="start_date" value="<?= $data['start_date'] ?>">
    </div>
    <div class="mb-3">
        <label for="">End Date</label>
        <input type="date" class="form-control" name="end_date" value="<?= $data['end_date'] ?>">
    </div>
    <div class="mb-3">
        <label for="">Current Price</label>
        <input type="number" class="form-control" name="current_price" value="<?= $data['current_price'] ?>">
    </div>
    <div class="mb-3">
        <label for="">Available Slots</label>
        <input type="number" class="form-control" name="available_slots" value="<?= $data['available_slots'] ?>">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
