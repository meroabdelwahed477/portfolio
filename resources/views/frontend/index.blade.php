<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portfolio - Backend Developer">
    <title>Portfolio | Backend Developer</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: {{ $primaryColor ?? '#6366f1' }};
            --secondary-color: {{ $secondaryColor ?? '#ec4899' }};
        }
        @if($theme == 'dark')
        body {
            background: #0f172a;
            color: #f8fafc;
        }
        .about, /* .certificates, */ .projects {
            background: #1e293b !important;
        }
        .card, .project-card, .certificate-card {
            background: #334155 !important;
            color: #f8fafc;
        }
        @elseif($theme == 'blue')
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #60a5fa;
        }
        @elseif($theme == 'green')
        :root {
            --primary-color: #10b981;
            --secondary-color: #34d399;
        }
        @elseif($theme == 'purple')
        :root {
            --primary-color: #8b5cf6;
            --secondary-color: #a78bfa;
        }
        @endif
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <div class="logo">
                    <span class="logo-text">Portfolio</span>
                </div>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="#home" class="nav-link active" data-en="Home">الرئيسية</a></li>
                    <li><a href="#about" class="nav-link" data-en="About">نبذة عني</a></li>
                    <li><a href="#experience" class="nav-link" data-en="Work Experience">الخبرات العملية</a></li>
                    <li><a href="#skills" class="nav-link" data-en="Skills">المهارات</a></li>
                    {{-- <li><a href="#certificates" class="nav-link" data-en="Certificates">الشهادات</a></li> --}}
                    <li><a href="#projects" class="nav-link" data-en="Projects">المشاريع</a></li>
                    <li><a href="#contact" class="nav-link" data-en="Contact">اتصل بي</a></li>
                    <li class="lang-toggle">
                        <button id="langBtn" class="lang-btn">
                            <i class="fas fa-language"></i> EN
                        </button>
                    </li>
                </ul>
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-background">
            <div class="animated-bg"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <div class="hero-image">
                    <div class="image-wrapper">
                        <img src="{{ $profile && $profile->photo ? Storage::url($profile->photo) : 'https://via.placeholder.com/300x300?text=Your+Photo' }}" alt="Profile Photo" id="profileImg">
                        <div class="image-border"></div>
                    </div>
                </div>
                <div class="hero-text">
                    <h1 class="hero-title">
                        <span class="greeting" data-en="Hello, I'm">مرحباً، أنا</span>
                        <span class="name" data-en="{{ $profile && $profile->name_en ?  $profile->name_en : 'I\'m' }}">{{ $profile ? $profile->name_ar : 'أحمد محمد' }}</span>
                    </h1>
                    <p class="hero-subtitle" data-en="{{ $profile && $profile->title_en ? $profile->title_en : 'Backend Developer & Software Engineer' }}">
                        {{ $profile ? $profile->title_ar : 'مطور Backend ومهندس برمجيات' }}
                    </p>
                    <p class="hero-description" data-en="{{ $profile && $profile->description_en ? $profile->description_en : 'Passionate about building scalable and efficient server-side applications.' }}">
                        {{ $profile ? $profile->description_ar : 'شغوف ببناء تطبيقات الخادم القابلة للتوسع والفعالة.' }}
                    </p>
                    <div class="hero-buttons">
                        <a href="#projects" class="btn btn-primary">
                            <span data-en="View My Work">شاهد أعمالي</span>
                            <i class="fas fa-briefcase"></i>
                        </a>
                        <a href="#contact" class="btn btn-primary">
                            <span data-en="Contact Me">تواصل معي</span>
                            <i class="fas fa-envelope"></i>
                        </a>
                        @if($profile && $profile->cv_file)
                        <a href="{{ Storage::url($profile->cv_file) }}" download class="btn btn-primary">
                            <span data-en="Download CV">تحميل السيرة الذاتية</span>
                            <i class="fas fa-download"></i>
                        </a>
                        @endif
                    </div>
                    <div class="social-links">
                        @foreach($socialLinks as $link)
                            @if($link->url && $link->url !== '')
                            <a href="{{ $link->url }}" 
                               @if($link->platform !== 'gmail')target="_blank"@endif
                               class="social-link" 
                               aria-label="{{ $link->platform }}">
                                <i class="{{ $link->icon ?? 'fas fa-link' }}"></i>
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-en="About Me">نبذة عني</h2>
                <div class="title-underline"></div>
            </div>
            <div class="about-content">
                <div class="about-text">
                    @if($profile)
                        <p class="about-description" data-en="{{ $profile->description_en ?? '' }}">
                            {{ $profile->description_ar }}
                    </p>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label" data-en="Name:">الاسم:</span>
                                <span class="info-value">{{ $profile->name_ar }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label" data-en="Email:">البريد الإلكتروني:</span>
                                <span class="info-value">{{ $profile->email }}</span>
                        </div>
                            @if($profile->phone)
                        <div class="info-item">
                            <span class="info-label" data-en="Phone:">الهاتف:</span>
                                <span class="info-value">{{ $profile->phone }}</span>
                        </div>
                            @endif
                            @if($profile->location_ar)
                        <div class="info-item">
                            <span class="info-label" data-en="Location:">الموقع:</span>
                                <span class="info-value" data-en="{{ $profile->location_en ?? '' }}">{{ $profile->location_ar }}</span>
                        </div>
                            @endif
                            @if($profile->experience_ar)
                        <div class="info-item">
                            <span class="info-label" data-en="Experience:">الخبرة:</span>
                                <span class="info-value" data-en="{{ $profile->experience_en ?? '' }}">{{ $profile->experience_ar }}</span>
                        </div>
                            @endif
                            @if($profile->availability_ar)
                        <div class="info-item">
                            <span class="info-label" data-en="Availability:">التوفر:</span>
                                <span class="info-value" data-en="{{ $profile->availability_en ?? '' }}">{{ $profile->availability_ar }}</span>
                            </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Work Experience Section -->
    <section id="experience" class="experience">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-en="Work Experience">الخبرات العملية</h2>
                <div class="title-underline"></div>
            </div>
            <div class="experience-timeline">
                @foreach($workExperiences as $experience)
                <div class="experience-item">
                    <div class="experience-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="experience-content">
                        <div class="experience-header">
                            <h3 class="experience-company" data-en="{{ $experience->company_name_en ?? '' }}">{{ $experience->company_name_ar }}</h3>
                            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                <span class="experience-type-badge">
                                    @if($experience->type == 'job')
                                        <i class="fas fa-briefcase"></i>
                                        <span data-en="Job">عمل</span>
                                    @else
                                        <i class="fas fa-graduation-cap"></i>
                                        <span data-en="Internship">تدريب</span>
                                    @endif
                                </span>
                                <span class="experience-badge">
                                    @if($experience->is_current)
                                        <span data-en="Current">حالياً</span>
                                    @else
                                        {{ $experience->start_date->format('Y') }} - {{ $experience->end_date ? $experience->end_date->format('Y') : 'حالياً' }}
                                    @endif
                                </span>
                                {{-- @if($experience->type == 'job' && $experience->experience_letter)
                                <a href="{{ Storage::url($experience->experience_letter) }}" download class="btn-download-experience" title="تحميل خطاب الخبرة">
                                    <i class="fas fa-file-pdf"></i>
                                    <span data-en="Download Experience Letter">تحميل خطاب الخبرة</span>
                                </a>
                                @endif --}}
                            </div>
                        </div>
                        <h4 class="experience-position" data-en="{{ $experience->position_en ?? '' }}">{{ $experience->position_ar }}</h4>
                        @if($experience->description_ar || $experience->description_en)
                        <p class="experience-description" data-en="{{ $experience->description_en ?? '' }}">
                            {{ $experience->description_ar }}
                        </p>
                        @endif
                        <div class="experience-dates">
                            <span class="date-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span data-en="Start Date">تاريخ البدء:</span>
                                {{ $experience->start_date->format('Y-m') }}
                            </span>
                            @if(!$experience->is_current && $experience->end_date)
                            <span class="date-item">
                                <i class="fas fa-calendar-check"></i>
                                <span data-en="End Date">تاريخ الانتهاء:</span>
                                {{ $experience->end_date->format('Y-m') }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="skills">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-en="Skills & Technologies">المهارات والتقنيات</h2>
                <div class="title-underline"></div>
            </div>
            <div class="skills-content">
                @php
                    $backendSkills = $skills->where('category', 'backend');
                    $frameworkSkills = $skills->where('category', 'frameworks');
                    $otherSkills = $skills->where('category', 'other');
                @endphp

                @if($backendSkills->count() > 0)
                <div class="skills-category">
                    <h3 class="category-title" data-en="Backend Technologies">تقنيات Backend</h3>
                    <div class="skills-grid">
                        @foreach($backendSkills as $skill)
                        <div class="skill-item">
                            @if($skill->icon)
                            <div class="skill-icon">
                                <i class="{{ $skill->icon }}"></i>
                            </div>
                            @endif
                            <div class="skill-info">
                                <h4 class="skill-name" data-en="{{ $skill->name_en ?? $skill->name_ar }}">{{ $skill->name_ar }}</h4>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-progress="{{ $skill->percentage }}"></div>
                                </div>
                                <span class="skill-percentage">{{ $skill->percentage }}%</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($frameworkSkills->count() > 0)
                <div class="skills-category">
                    <h3 class="category-title" data-en="Frameworks & Tools">الأطر والأدوات</h3>
                    <div class="skills-grid">
                        @foreach($frameworkSkills as $skill)
                        <div class="skill-item">
                            @if($skill->icon)
                            <div class="skill-icon">
                                <i class="{{ $skill->icon }}"></i>
                            </div>
                            @endif
                            <div class="skill-info">
                                <h4 class="skill-name" data-en="{{ $skill->name_en ?? $skill->name_ar }}">{{ $skill->name_ar }}</h4>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-progress="{{ $skill->percentage }}"></div>
                                </div>
                                <span class="skill-percentage">{{ $skill->percentage }}%</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($otherSkills->count() > 0)
                <div class="skills-category">
                    <h3 class="category-title" data-en="Other Skills">مهارات أخرى</h3>
                    <div class="tags-container">
                        @foreach($otherSkills as $skill)
                        <span class="skill-tag" data-en="{{ $skill->name_en ?? $skill->name_ar }}">{{ $skill->name_ar }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- <!-- Certificates Section -->
    <section id="certificates" class="certificates">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-en="Certificates">الشهادات</h2>
                <div class="title-underline"></div>
            </div>
            <div class="certificates-grid">
                @foreach($certificates as $certificate)
                <div class="certificate-card" data-cert-id="{{ $certificate->id }}">
                    <div class="certificate-image">
                        <img src="{{ Storage::url($certificate->image) }}" alt="{{ $certificate->title_ar }}">
                    </div>
                    <div class="certificate-content">
                        <h3 class="certificate-title" data-en="{{ $certificate->title_en ?? '' }}">{{ $certificate->title_ar }}</h3>
                        <button class="btn btn-view-certificate" data-cert-id="{{ $certificate->id }}">
                            <span data-en="View Details">عرض التفاصيل</span>
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Certificate Detail Modal -->
    <div class="certificate-modal" id="certificateModal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <button class="modal-close" id="closeCertModal">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-body">
                <h2 class="modal-title" id="modalCertTitle"></h2>
                <div class="certificate-detail-image">
                    <img id="modalCertImage" src="" alt="Certificate">
                </div>
                <div class="certificate-actions">
                    <a href="#" id="downloadCertImage" class="btn btn-primary" download>
                        <span data-en="Download as Image">تحميل كصورة</span>
                        <i class="fas fa-download"></i>
                    </a>
                    <a href="#" id="downloadCertPdf" class="btn btn-secondary" download>
                        <span data-en="Download as PDF">تحميل كـ PDF</span>
                        <i class="fas fa-file-pdf"></i>
                    </a>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Projects Section -->
    <section id="projects" class="projects">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-en="Projects I Contributed To">المشاريع التي شاركت بها</h2>
                <div class="title-underline"></div>
            </div>
            
            <!-- Project Filter -->
            <div class="project-filter">
                <button class="filter-btn active" data-filter="all">
                    <i class="fas fa-th"></i>
                    <span data-en="All">الكل</span>
                </button>
                <button class="filter-btn" data-filter="web">
                    <i class="fas fa-globe"></i>
                    <span>Web</span>
                </button>
                <button class="filter-btn" data-filter="api-web">
                    <i class="fas fa-server"></i>
                    <span>API Web</span>
                </button>
                <button class="filter-btn" data-filter="api-mobile">
                    <i class="fas fa-mobile-alt"></i>
                    <span>API Mobile</span>
                </button>
            </div>

            <div class="projects-grid">
                @foreach($projects as $project)
                <div class="project-card" data-category="{{ $project->category }}" data-project-id="{{ $project->id }}">
                    <div class="project-image">
                        <img src="{{ $project->thumbnail ? Storage::url($project->thumbnail) : 'https://via.placeholder.com/600x400?text=Project' }}" alt="{{ $project->title_ar }}">
                        <div class="project-overlay">
                            <div class="project-links">
                                <a href="#" class="project-link view-project-details" data-project-id="{{ $project->id }}" aria-label="View Project">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($project->link)
                                <a href="{{ $project->link }}" target="_blank" class="project-link" aria-label="Visit Website">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="project-content">
                        <span class="project-category">
                            @if($project->category == 'web') Web
                            @elseif($project->category == 'api-web') API Web
                            @else API Mobile
                            @endif
                        </span>
                        <h3 class="project-title" data-en="{{ $project->title_en ?? '' }}">{{ $project->title_ar }}</h3>
                        @if($project->company_name_ar || $project->company_name_en)
                        <div class="project-company">
                            <i class="fas fa-building"></i>
                            <span class="company-label" data-en="Company:">شركة:</span>
                            <span class="company-name" data-en="{{ $project->company_name_en ?? '' }}">{{ $project->company_name_ar }}</span>
                        </div>
                        @endif
                        <p class="project-description" data-en="{{ $project->description_en ?? '' }}">
                            {{ $project->description_ar }}
                        </p>
                        {{-- @if($project->technologies)
                        <div class="project-tech">
                            @foreach($project->technologies as $tech)
                            <span class="tech-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                        @endif --}}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Project Detail Modal -->
    <div class="project-modal" id="projectModal">
        <div class="modal-overlay"></div>
        <div class="modal-content project-modal-content">
            <button class="modal-close" id="closeProjectModal">
                <i class="fas fa-times"></i>
            </button>
            <div class="project-detail-body">
                <div class="project-detail-header">
                    <span class="project-detail-category" id="modalProjectCategory"></span>
                    <h2 class="project-detail-title" id="modalProjectTitle"></h2>
                </div>
                
                <div class="project-detail-content">
                    <div class="project-detail-description">
                        <h3 data-en="About Project">نبذة عن المشروع</h3>
                        <p id="modalProjectDescription"></p>
                    </div>
                    
                    <div class="project-detail-features">
                        <h3 data-en="Key Features (My Role)">المميزات الرئيسية (دوري في المشروع)</h3>
                        <ul id="modalProjectFeatures"></ul>
                    </div>
                    
                    {{-- <div class="project-detail-tech">
                        <h3 data-en="Technologies Used">التقنيات المستخدمة</h3>
                        <div id="modalProjectTech"></div>
                    </div> --}}
                    
                    <div class="project-detail-gallery">
                        <h3 data-en="Project Image">صورة المشروع</h3>
                        <div class="gallery-container">
                            <div class="gallery-main">
                                <img id="galleryMainImage" src="" alt="Project Image">
                            </div>
                        </div>
                    </div>
                    
                    <div class="project-detail-actions">
                        <a href="#" id="modalProjectLink" target="_blank" class="btn btn-primary" style="display: none;">
                            <span data-en="Visit Website">زيارة الموقع</span>
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title" data-en="Get In Touch">تواصل معي</h2>
                <div class="title-underline"></div>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    @if($profile)
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4 data-en="Email">البريد الإلكتروني</h4>
                            <p>{{ $profile->email }}</p>
                        </div>
                    </div>
                    @if($profile->phone)
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4 data-en="Phone">الهاتف</h4>
                            <p>{{ $profile->phone }}</p>
                        </div>
                    </div>
                    @endif
                    @if($profile->location_ar)
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4 data-en="Location">الموقع</h4>
                            <p data-en="{{ $profile->location_en ?? '' }}">{{ $profile->location_ar }}</p>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
                <form class="contact-form" id="contactForm" action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="name" name="name" required>
                        <label for="name" data-en="Your Name">اسمك</label>
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" required>
                        <label for="email" data-en="Your Email">بريدك الإلكتروني</label>
                    </div>
                    <div class="form-group">
                        <input type="text" id="subject" name="subject" required>
                        <label for="subject" data-en="Subject">الموضوع</label>
                    </div>
                    <div class="form-group">
                        <textarea id="message" name="message" rows="5" required></textarea>
                        <label for="message" data-en="Your Message">رسالتك</label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <span data-en="Send Message">إرسال الرسالة</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <p>&copy; 2024 <span data-en="All Rights Reserved">جميع الحقوق محفوظة</span></p>
                <div class="footer-social">
                    @foreach($socialLinks as $link)
                        @if($link->url && $link->url !== '')
                        <a href="{{ $link->url }}" 
                           @if($link->platform !== 'gmail')target="_blank"@endif
                           class="footer-social-link" 
                           aria-label="{{ $link->platform }}">
                            <i class="{{ $link->icon ?? 'fas fa-link' }}"></i>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Pass dynamic data to JavaScript - MUST be before script.js
        const projectsData = {
            @foreach($projects as $project)
            {{ $project->id }}: {
                title: @json($project->title_ar),
                titleEn: @json($project->title_en ?? ''),
                category: @json($project->category),
                description: @json($project->description_ar),
                descriptionEn: @json($project->description_en ?? ''),
                features: @json(is_array($project->features_ar) ? $project->features_ar : []),
                featuresEn: @json(is_array($project->features_en) ? $project->features_en : []),
                tech: @json(is_array($project->technologies) ? $project->technologies : []),
                images: [
                    @if($project->thumbnail)
                    @json(Storage::url($project->thumbnail)),
                    @endif
                    @foreach($project->images as $image)
                    @json(Storage::url($image->image_path))@if(!$loop->last),@endif
                    @endforeach
                ],
                link: @json($project->link ?? '#')
            }@if(!$loop->last),@endif
            @endforeach
        };

        {{-- const certificatesData = {
            @foreach($certificates as $certificate)
            {{ $certificate->id }}: {
                title: @json($certificate->title_ar),
                titleEn: @json($certificate->title_en ?? ''),
                image: @json(Storage::url($certificate->image)),
                imageDownload: @json(Storage::url($certificate->image)),
                pdfDownload: @json($certificate->pdf_file ? Storage::url($certificate->pdf_file) : '#')
            }@if(!$loop->last),@endif
            @endforeach
        }; --}}
        
        console.log('Projects and certificates data loaded:', {
            projectsCount: Object.keys(projectsData).length,
            certificatesCount: 0 // Object.keys(certificatesData).length
        });
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>

