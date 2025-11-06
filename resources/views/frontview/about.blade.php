@extends('layouts.front')
@section('title', 'About Us')
@section('content')

    @include('common.alert')

    <!-- ================================
             BRAND STORY & FOUNDERS' VISION
        ================================ -->
    <section class="py-5 bg-light" id="brand-story">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-md-6" data-aos="fade-right">
                    <img src="{{ asset('assets/front/images/about.png') }}" class="img-fluid rounded shadow"
                        alt="Oroveda Founders">
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <h2 class="section-title aos-init aos-animate" data-aos="fade-up">Our Brand Story & Founders’ Vision
                    </h2>

                    <p class="text-muted">
                        Oroveda Organics was founded with a heartfelt purpose — to bring purity, tradition, and affordability together in everyday wellness. As healthcare professionals, we have witnessed that true health is not just about treatment but about how consciously we live and what we choose to bring into our homes.
                        
                    </p>
                    <p class="text-muted">
                         The name Oroveda, meaning Golden Wisdom, beautifully reflects our philosophy — merging the golden purity of nature (Oro) with the timeless knowledge of Ayurveda and Indian tradition (Veda). Our journey began with pure Bilona Cow Ghee, crafted using age-old methods, staying true to heritage while ensuring quality and trust.
                    </p>
                    <blockquote class="blockquote border-start border-warning ps-3 mt-4">
                        <p class="mb-0">“We don’t just make ghee — we preserve a legacy.”</p>
                        <footer class="blockquote-footer mt-2">The Oroveda Founders</footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 vision-mission">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="fw-bold">Our Vision & Mission</h2>
            <div class="title-line"></div>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Vision -->
            <div class="col-lg-5">
                <div class="vm-card vision">
                    <h4 class="vm-title">Our Vision</h4>
                    <p>
                        To make genuine, organic, and traditional products accessible to every household while empowering farmers and preserving the cultural essence of India’s nutritional heritage.
                    </p>
                </div>
            </div>

            <!-- Mission -->
            <div class="col-lg-5">
                <div class="vm-card mission">
                    <h4 class="vm-title">Our Mission</h4>
                    <p>
                        To revive traditional food wisdom by delivering pure, handcrafted, and affordable products that nourish the body and mind, support sustainable rural livelihoods, and inspire a lifestyle rooted in simplicity and wellness.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

    <!-- ================================
                  JOURNEY OF OROVEDA
        ================================ -->
    <section id="journey" class="py-5">
        <div class="container">

            <h2 class="section-title aos-init aos-animate" data-aos="fade-up">Founder’s  <span
                    class="text-warning">Note</span> </h2>
                    
            <div class="timeline">
              

                   
                    <div class="timeline-content ">
                        
                        <p class="text-muted small mb-0">
                            At Oroveda, our values are the soul of everything we do. We believe purity is not just a standard, but a promise — every product embodies authenticity and care. Affordability is equally important, as we strive to make organic living accessible to all. Our deep respect for sustainability guides us toward eco-friendly packaging and carbon-conscious practices, ensuring our growth is gentle on the planet. Above all, we remain committed to trust and tradition — honoring the legacy of our ancestors while adapting to the needs of modern wellness.
                        </p>
                    </div>
                    <div class="timeline-content">
                        
                        <p class="text-muted small mb-0">
                            At Oroveda Organics, we are not just building a brand, but nurturing a movement — one that celebrates mindful living, supports our farmers, and reconnects us to the roots of health and harmony. As we grow and introduce more natural products like makhana, oils, seeds, nuts, and spices, our promise remains unchanged — to bring pure, affordable, and authentic goodness from the farm to your home.
                        </p>
                    </div>
                    <div class="timeline-content  mb-5">
                        
                        <p class="text-muted small mb-0">
                           Thank you for being part of this journey toward a purer, more conscious world.
                        </p>
                    </div>
                

                <!-- 2020 -->
                
                    <div class="timeline-content">
                        <h5 class="fw-semibold text-warning">– Dr. HK Dulera & Dr. Jigisha Darji</h5>
                        <p class="text-muted small mb-0">
                           
Founders, Oroveda Organics<br>
Golden Purity. Ancient Wisdom. Modern Trust.
                        </p>
                    </div>
                </div>

             
        </div>
    </section>

    <!-- ================================
                 OROVEDA PHILOSOPHY
        ================================ -->
   <section class="py-5" id="philosophy">
    <div class="container text-center">
        <h2 class="fw-bold mb-5" data-aos="fade-up">The Oroveda Philosophy</h2>
        <div class="row g-4">
            <!-- Purity -->
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="mb-3"><i class="bi bi-droplet-half text-warning fs-1"></i></div>
                        <h5 class="fw-semibold mb-2">Purity</h5>
                        <p class="text-muted small">
                            We source milk only from <strong>indigenous Gir cows</strong> and follow natural grazing
                            methods.
                            No preservatives, no shortcuts — only pure, golden ghee made from love and integrity.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tradition -->
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="mb-3"><i class="bi bi-mortarboard-fill text-warning fs-1"></i></div>
                        <h5 class="fw-semibold mb-2">Tradition</h5>
                        <p class="text-muted small">
                            Our <em>Bilona process</em> is inspired by Ayurveda — churning curd with a wooden hand whisk
                            to retain nutrients
                            and energy, exactly as done for centuries in Indian households.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Sustainability -->
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="mb-3"><i class="bi bi-recycle text-warning fs-1"></i></div>
                        <h5 class="fw-semibold mb-2">Sustainability</h5>
                        <p class="text-muted small">
                            From ethical dairy practices to eco-friendly packaging, Oroveda strives to create wellness
                            for both people and planet. We ensure <strong>zero waste and mindful sourcing</strong> every
                            step of the way.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Affordable -->
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="mb-3"><i class="bi bi-cash-stack text-warning fs-1"></i></div>
                        <h5 class="fw-semibold mb-2">Affordable</h5>
                        <p class="text-muted small">
                            We believe purity should be a privilege for everyone, not a luxury for few. Oroveda is committed to making authentic, hand-churned ghee accessible to every household without compromising on quality or values.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


    <!-- ================================
                    PROCESS SNAPSHOTS
        ================================ -->
    <section class="py-5 bg-light" id="process-snapshots">
        <div class="container">
            <h2 class="fw-bold text-center mb-5" data-aos="fade-up">Our Process: From Farm to Jar</h2>
            <div class="row g-4 text-center">
                <!-- Step 1 -->
                <div class="col-md-3 col-sm-6" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card border-0 h-100">
                        <img src="{{ asset('assets/front/images/gir-cow.jpg') }}" class="card-img-top rounded shadow-sm"
                            alt="Milking Gir Cows">
                        <div class="card-body">
                            <h6 class="fw-semibold text-warning">Step 1</h6>
                            <p class="small text-muted">Fresh  milk is collected from happy,  Gir cows.</p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="col-md-3 col-sm-6" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card border-0 h-100">
                        <img src="{{ asset('assets/front/images/curd-formation.png') }}"
                            class="card-img-top rounded shadow-sm" alt="Curd Formation">
                        <div class="card-body">
                            <h6 class="fw-semibold text-warning">Step 2</h6>
                            <p class="small text-muted">The milk is set into curd overnight to preserve enzymes and
                                probiotics.</p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="col-md-3 col-sm-6" data-aos="zoom-in" data-aos-delay="300">
                    <div class="card border-0 h-100">
                        <img src="{{ asset('assets/front/images/Bilona-Churning.png') }}"
                            class="card-img-top rounded shadow-sm" alt="Bilona Churning">
                        <div class="card-body">
                            <h6 class="fw-semibold text-warning">Step 3</h6>
                            <p class="small text-muted">The curd is hand-churned using the traditional wooden
                                <em>Bilona</em>.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="col-md-3 col-sm-6" data-aos="zoom-in" data-aos-delay="400">
                    <div class="card border-0 h-100">
                        <img src="{{ asset('assets/front/images/Slow-Simmering.png') }}"
                            class="card-img-top rounded shadow-sm" alt="Slow Simmering">
                        <div class="card-body">
                            <h6 class="fw-semibold text-warning">Step 4</h6>
                            <p class="small text-muted">Butter is gently simmered to produce golden, aromatic Oroveda Ghee.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
