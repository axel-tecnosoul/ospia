<div class="appBottomMenu">
  <a href="index.php" class="item animate__animated animate__bounceIn">
    <div class="col a1">
      <button type="button" class="btn btn-icon btn-primary3 me-1 mb-1">
        <ion-icon name="home" style="pointer-events: none;"></ion-icon>
      </button>
    </div>
  </a>
  <a href="tel: 0800 999 1421" class="item animate__animated animate__bounceIn">
    <div class="col">
      <button type="button" class="btn btn-icon btn-primary me-1 mb-1">
        <ion-icon name="call" style="pointer-events: none;" color="danger"></ion-icon>
      </button>
    </div>
  </a>
  <a href="datos.php" class="item animate__animated animate__bounceIn">
    <div class="col">
      <button type="button" class="btn btn-icon btn-primary me-1 mb-1">
        <ion-icon name="person" style="pointer-events: none;"></ion-icon>
      </button>
    </div>
  </a><?php
  
  //if ($_SESSION['user']['id'] == 1 or $_SESSION['user']['id'] == 20){?>
    <a href="logout.php" class="item animate__animated animate__bounceIn">
      <div class="col">
        <button type="button" class="btn btn-icon btn-primary me-1 mb-1">
          <ion-icon name="log-out-outline" style="pointer-events: none;transform: rotate(180deg);"></ion-icon>
        </button>
      </div>
    </a><?php
  //}?>
</div>