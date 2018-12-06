<div id="carousel">
    <?php foreach ($data as $item): ?>
        <div class="pc-item">
            <div class="pc-image">
                <img src="/images/<?= $item['post_thumbnail'] ?>" class="center-block" alt="<?= $item['post_title'] ?>">
            </div>
            <div class="pc-title">
                <h4><a href=""><?= $item['post_title'] ?></a></h4>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php
\nooclik\blog\widgets\postCarousel\PostCarouselAsset::register($this);
$js = <<<JS
$('#carousel').slick({
  autoplay: $autoplay,
  arrows: true,
  infinite: true,
  slidesToShow: $slideToShow,
  slidesToScroll: $slideToShow,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: $slideToShow,
        slidesToScroll: $slideToShow,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    ]
});
JS;
$this->registerJS($js);

