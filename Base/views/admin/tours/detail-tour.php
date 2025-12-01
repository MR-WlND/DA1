<?php include PATH_VIEW . 'layout/header.php'; ?>

<style>
body {
    font-family: 'Inter', sans-serif;
    background: #f3f4f6;
    color: #1f2937;
}
.tour-detail {
    max-width: 1200px;
    margin: 40px auto;
}

/* Hero Gallery */
.hero-gallery {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 12px 25px rgba(0,0,0,0.15);
}
.hero-gallery img {
    width: 100%;
    height: 450px;
    object-fit: cover;
    transition: transform 0.5s;
}
.hero-gallery:hover img {
    transform: scale(1.05);
}
.hero-overlay {
    position: absolute;
    bottom: 20px;
    left: 30px;
    color: #fff;
    text-shadow: 0 2px 10px rgba(0,0,0,0.6);
}
.hero-overlay h1 {
    font-size: 36px;
    font-weight: 700;
    margin: 0;
}
.hero-overlay .tags {
    margin-top: 10px;
}
.hero-overlay .tag {
    display: inline-block;
    background: linear-gradient(90deg,#8b5cf6,#c084fc);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    margin-right: 6px;
}

/* Section Cards */
.section-card {
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    margin-top: 30px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: 0.3s;
}
.section-card:hover {
    box-shadow: 0 12px 25px rgba(0,0,0,0.12);
}

/* Timeline / Itinerary */
.timeline {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.timeline-item {
    position: relative;
    padding-left: 50px;
    border-left: 3px solid #6366f1;
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: -10px;
    top: 5px;
    width: 20px;
    height: 20px;
    background: #6366f1;
    border-radius: 50%;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}
.timeline-item h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}
.timeline-item p {
    margin: 4px 0 0 0;
    color: #4b5563;
    font-size: 14px;
}

/* Departure cards */
.departure-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(280px,1fr));
    gap: 20px;
}
.departure-card {
    background: linear-gradient(145deg,#ffffff,#f1f1f1);
    border-radius: 16px;
    padding: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: 0.3s;
}
.departure-card:hover {
    box-shadow: 0 12px 25px rgba(0,0,0,0.12);
    transform: translateY(-4px);
}
.departure-card h5 {
    margin: 0 0 8px 0;
    font-weight: 600;
}
.departure-card .price-slot {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    font-weight: 600;
    font-size: 14px;
}
.departure-card .btn-book {
    display: block;
    margin-top: 12px;
    text-align: center;
    background: #10b981;
    color: #fff;
    padding: 6px 0;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
}
.departure-card .btn-book:hover {
    background: #059669;
}

/* Policy & Description */
.collapsible {
    background: #6366f1;
    color: #fff;
    cursor: pointer;
    padding: 12px 16px;
    width: 100%;
    border: none;
    border-radius: 12px;
    text-align: left;
    font-size: 16px;
    font-weight: 600;
    outline: none;
    margin-top: 10px;
    transition: 0.25s;
}
.collapsible:hover {
    background: #4f46e5;
}
.content-collapsible {
    padding: 0 16px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease-out;
    background: #f9fafb;
    border-radius: 0 0 12px 12px;
}

/* Back Button */
.btn-back {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: #ef4444;
    color: #fff;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.25s;
}
.btn-back:hover {
    background: #b91c1c;
}
</style>

<div class="tour-detail">
    <!-- Hero Gallery -->
    <?php if (!empty($tour['gallery'])): ?>
        <div class="hero-gallery">
            <?php foreach ($tour['gallery'] as $i => $img): ?>
                <img class="slide" src="<?= BASE_ASSETS_UPLOADS . $img['image_url'] ?>" style="display: <?= $i===0?'block':'none' ?>;">
            <?php endforeach; ?>
            <div class="hero-overlay">
                <h1><?= htmlspecialchars($tour['name']) ?></h1>
                <div class="tags">
                    <span class="tag"><?= htmlspecialchars($tour['category_name'] ?? '') ?></span>
                    <span class="tag"><?= ($tour['tour_type']=='domestic')?'Nội địa':'Quốc tế' ?></span>
                </div>
            </div>
            <button onclick="plusSlide(-1)" style="position:absolute;top:50%;left:10px;border-radius:50%;width:30px;height:30px;"></button>
            <button onclick="plusSlide(1)" style="position:absolute;top:50%;right:10px;border-radius:50%;width:30px;height:30px;"></button>
        </div>

        <script>
            let slideIndex = 0;
            const slides = document.querySelectorAll('.slide');
            function showSlide(n){ slides.forEach(s=>s.style.display='none'); slides[n].style.display='block'; }
            function plusSlide(n){ slideIndex=(slideIndex+n+slides.length)%slides.length; showSlide(slideIndex);}
        </script>
    <?php endif; ?>

    <!-- Lộ trình -->
    <div class="section-card">
        <h2>Lộ trình chi tiết</h2>
        <div class="timeline">
            <?php foreach($tour['destinations']??[] as $d): ?>
                <div class="timeline-item">
                    <h4><?= htmlspecialchars($d['name']) ?></h4>
                    <p><?= htmlspecialchars($d['description']??$tour['description']??'') ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Lịch khởi hành -->
    <div class="section-card">
        <h2>Lịch khởi hành & Giá</h2>
        <div class="departure-grid">
            <?php foreach($tour['departures']??[] as $dep): ?>
                <div class="departure-card">
                    <h5><?= $dep['start_date'] ?? '-' ?> → <?= $dep['end_date'] ?? '-' ?></h5>
                    <div class="price-slot">
                        <span>Giá: <?= number_format($dep['current_price']??0) ?> đ</span>
                        <span>Số chỗ: <?= $dep['available_slots']??0 ?></span>
                    </div>
                    <a href="<?= BASE_URL ?>?action=book&id=<?= $tour['id'] ?>&dep_id=<?= $dep['departure_id'] ?>" class="btn-book">Đặt chỗ</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Chính sách & mô tả -->
    <div class="section-card">
        <?php if(!empty($tour['policy_details'])): ?>
            <button class="collapsible">Chính sách hủy</button>
            <div class="content-collapsible"><p><?= nl2br(htmlspecialchars($tour['policy_details'])) ?></p></div>
        <?php endif; ?>
        <button class="collapsible">Mô tả chi tiết</button>
        <div class="content-collapsible"><p><?= nl2br(htmlspecialchars($tour['description']??'')) ?></p></div>
    </div>

    <a href="<?= BASE_URL ?>?action=list-tour" class="btn-back">Quay lại</a>
</div>

<script>
const coll = document.querySelectorAll(".collapsible");
coll.forEach(c=>{
    c.addEventListener("click", function(){
        this.classList.toggle("active");
        const content=this.nextElementSibling;
        if(content.style.maxHeight){ content.style.maxHeight=null;}
        else{ content.style.maxHeight=content.scrollHeight+"px";}
    });
});
</script>
