<?php
// Template Name: Contact

get_header(); ?>

<?php $fields = get_fields('options'); ?>
<div id="map"></div>
<div class="container p-4">
  <div class="row">
    <div class="container contact">
      <div class="social-detail">
        <div class="row">
          <?php if (isset($fields['site_phones'][0]['site_phone'])): ?>
            <div class="col-xl-6 col-lg-6 col-12 mb-xl-0 mb-24">
              <a href="tel:<?php echo $fields['site_phones'][0]['site_phone']; ?>" class=" ">
                <i class="fal fa-phone-alt"></i>
                <span><?php echo $fields['site_phones'][0]['site_phone']; ?></span>
              </a>
            </div>
          <?php endif; ?>
          <?php if ($fields['site_e-mail']): ?>
            <div class="col-xl-6 col-lg-6 col-12 mb-xl-0 mb-24">
              <a href="mailto:<?php echo $fields['site_e-mail']; ?>" class=" ">
                <i class="fal fa-envelope"></i>
                <span><?php echo $fields['site_e-mail']; ?></span>
              </a>
            </div>
          <?php endif; ?>
          <?php foreach ($fields['site_address'] as $address): ?>
            <div class="col-xl-6 col-lg-6 col-12 offset-xl-0 mt-2">
              <div class="address">
                <i class="fal fa-map-marker-alt"></i>
                <h6 class="light-black"><?php echo $address['pupazzo_address']; ?></h6>
              </div>
            </div>
          <?php endforeach; ?>

        </div>
      </div>

      <div class="shipping p-96">
        <form name="returnform" action="" method="POST">
          <div class="row">
            <div class="col-lg-6">
              <div class="PupazzoInput">
                <input type="text" name="firstName" id="city" placeholder="" class="form-control mb-16" required="">
                <label>სახელი</label>
                <div data-lastpass-icon-root="" style="position: relative !important; height: 0px !important; width: 0px !important; float: left !important;"></div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="PupazzoInput">
                <input type="text" name="lastName" id="region" placeholder="" class="form-control mb-16" required="">
                <label>გვარი</label>
              </div>
            </div>
            <div class="col-12">
              <div class="PupazzoInput">
                <input type="email" name="E-mail" id="address" placeholder="" class="form-control mb-16" required="">
                <label>ელ-ფოსტა</label>
              </div>
            </div>
            <div class="col-12">
              <div class="PupazzoInput">
                <input type="text" name="subject" id="address" placeholder="" class="form-control mb-16" required="">
                <label>დანიშნულება</label>
              </div>
            </div>
            <div class="col-12">
              <div class="PupazzoInput">
                <textarea type="text" name="message" id="comment" placeholder="" class="form-control mb-16" required=""></textarea>
                <label>წერილი</label>
              </div>
            </div>
            <div class="col-12" style="margin-top: 40px">
              <div class="row">
                <div class="col-md-12">
                  <button id="send" class="cus-btn primary w-100">გაგზავნა</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php get_footer();
