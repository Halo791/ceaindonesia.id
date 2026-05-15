@extends('layouts.app')

@section('title', config('app.name'))

@php
    $homeContent = $homeContent ?? [];
    $locale = $currentLocale ?? 'id';
    $homeText = [
        'platform_label' => 'Platform Mandat Kolektif',
        'platform_title' => 'Ekosistem yang menghubungkan sumber daya, komunitas, dan respon kemanusiaan.',
        'principles_label' => 'Prinsip & Karakter',
        'principles_title' => 'Kepercayaan dibangun lewat kesetaraan, transparansi, dan akuntabilitas kolektif.',
        'governance_label' => 'Struktur & Tata Kelola',
        'governance_title' => 'Gerak kolektif ditopang oleh arsitektur mandat dan tata kelola sumber daya.',
        'stories_label' => 'Cerita Lapangan',
        'stories_title' => 'Foto, narasi, dan respon lokal dari simpul Pooling Fund - KSO.',
        'learn' => $ui['learn'] ?? 'Pelajari',
        'read_more' => $ui['read_more'] ?? 'Baca selengkapnya',
        'hub_type' => 'Simpul',
        'member_type' => 'Anggota',
    ];

    if ($locale === 'en') {
        $homeText = array_merge($homeText, [
            'platform_label' => 'Collective Mandate Platform',
            'platform_title' => 'An ecosystem connecting resources, communities, and humanitarian response.',
            'principles_label' => 'Principles & Character',
            'principles_title' => 'Trust is built through equality, transparency, and collective accountability.',
            'governance_label' => 'Structure & Governance',
            'governance_title' => 'Collective movement is supported by mandate architecture and resource governance.',
            'stories_label' => 'Field Stories',
            'stories_title' => 'Photos, narratives, and local responses from Pooling Fund - KSO hubs.',
            'hub_type' => 'Hub',
            'member_type' => 'Member',
        ]);
    }
    $heroVideoPath = (string) ($homeContent['video_path'] ?? '/assets/img/cea/video.mp4');
    $heroVideoSrc = preg_match('/^https?:\/\//', $heroVideoPath) ? $heroVideoPath : asset(ltrim($heroVideoPath, '/'));
    $disasterImages = [
        'psychosocial' => asset('assets/img/lapangan/pkbi-aceh-dukungan-psikososial.jpeg'),
        'children' => asset('assets/img/lapangan/pkbi-aceh-karya-anak.jpeg'),
        'waterOne' => asset('assets/img/lapangan/walhi-sumut-tandon-air-1.jpeg'),
        'waterTwo' => asset('assets/img/lapangan/walhi-sumut-tandon-air-2.jpeg'),
        'logistics' => asset('assets/img/lapangan/walhi-sumbar-distribusi-logistik.jpeg'),
    ];
    $focusAreas = [
        ['title' => 'Mandat Kolektif', 'description' => 'Satu mandat bersama untuk memperkuat kepemimpinan lokal dan respon kemanusiaan yang berkeadilan.', 'image' => $disasterImages['logistics'], 'href' => '/profil/mandat-visi-nilai'],
        ['title' => 'Tanpa Badan Hukum Baru', 'description' => 'Platform kerja sama operasional antar CSO yang menjaga kedaulatan organisasi anggota.', 'image' => $disasterImages['children'], 'href' => '/profil/riwayat'],
        ['title' => 'Local First', 'description' => 'Keputusan dan sumber daya diarahkan sedekat mungkin dengan komunitas yang menghadapi krisis.', 'image' => $disasterImages['waterTwo'], 'href' => '/profil/tujuan-prinsip'],
    ];
    $governanceItems = [
        ['label' => 'Arsitektur Mandat', 'title' => 'Simpul regional otonom terhubung dalam satu visi kepemimpinan lokal.', 'description' => 'Forum Anggota memegang mandat kolektif dengan prinsip one organization, one vote, sementara fungsi strategis dan operasional dipisahkan untuk menjaga akuntabilitas.', 'image' => $disasterImages['logistics'], 'href' => '/profil/struktur-gerak'],
        ['label' => 'Tata Kelola Sumber Daya', 'title' => 'Dana dikelola sebagai mandat kolektif, bukan aset lembaga.', 'description' => 'Pengambilan keputusan dilakukan oleh mereka yang paling dekat dengan krisis agar respon cepat, transparan, dan relevan dengan kebutuhan komunitas.', 'image' => $disasterImages['waterOne'], 'href' => '/profil/sumber-daya'],
    ];
    $stats = [
        ['value' => '1', 'label' => 'Mandat kolektif'],
        ['value' => '7', 'label' => 'Simpul regional'],
        ['value' => '33', 'label' => 'Anggota tercatat'],
    ];
    $fieldStories = [
        [
            'title' => 'Ruang Aman Pemulihan Anak Penyintas',
            'label' => 'PKBI Aceh',
            'image' => $disasterImages['psychosocial'],
            'description' => 'Di tengah situasi pascabencana yang masih menyisakan trauma, anak-anak penyintas di Aceh perlahan belajar kembali untuk tersenyum, bermain, dan merasa aman melalui layanan dukungan psikososial.',
        ],
        [
            'title' => 'Harapan yang Tumbuh dari Gambar Anak-Anak',
            'label' => 'PKBI Aceh',
            'image' => $disasterImages['children'],
            'description' => 'Melalui aktivitas menggambar, bermain, dan belajar bersama, anak-anak diajak mengekspresikan perasaan setelah melewati situasi penuh ketakutan dan kehilangan.',
        ],
        [
            'title' => 'Akses Air Bersih untuk Warga Terdampak',
            'label' => 'WALHI Sumut',
            'image' => $disasterImages['waterOne'],
            'description' => 'Pemasangan tandon air menjadi bagian dari respon cepat untuk memastikan kebutuhan dasar warga tetap terpenuhi di wilayah yang terdampak krisis dan gangguan akses layanan.',
        ],
        [
            'title' => 'Gotong Royong Menyiapkan Sarana Air',
            'label' => 'WALHI Sumut',
            'image' => $disasterImages['waterTwo'],
            'description' => 'Warga dan relawan bekerja bersama menyiapkan sarana air bersih. Respon kemanusiaan menjadi lebih kuat ketika komunitas terlibat langsung dalam proses pemulihan.',
        ],
        [
            'title' => 'Distribusi Logistik bagi Penyintas Bencana',
            'label' => 'WALHI Sumbar',
            'image' => $disasterImages['logistics'],
            'description' => 'Bantuan logistik disalurkan melalui kerja kolektif relawan dan simpul lokal agar kebutuhan mendesak penyintas dapat dijawab secara cepat, transparan, dan tepat sasaran.',
        ],
    ];
    $principles = ['Satu CSO satu suara', 'Berbasis kebutuhan komunitas', 'Kecepatan sebagai nilai utama', 'Transparansi sebagai aset strategis', 'Akuntabilitas kolektif', 'Local leadership & local first'];

    if ($locale === 'en') {
        $focusAreas = [
            ['title' => 'Collective Mandate', 'description' => 'One shared mandate to strengthen local leadership and a just humanitarian response.', 'image' => $disasterImages['logistics'], 'href' => '/profil/mandat-visi-nilai'],
            ['title' => 'No New Legal Entity', 'description' => 'An operational cooperation platform among CSOs that protects the sovereignty of member organizations.', 'image' => $disasterImages['children'], 'href' => '/profil/riwayat'],
            ['title' => 'Local First', 'description' => 'Decisions and resources are placed as close as possible to communities facing crisis.', 'image' => $disasterImages['waterTwo'], 'href' => '/profil/tujuan-prinsip'],
        ];
        $governanceItems = [
            ['label' => 'Mandate Architecture', 'title' => 'Autonomous regional hubs connected through one vision of local leadership.', 'description' => 'The Member Forum holds a collective mandate through one organization, one vote, while strategic and operational functions are separated to maintain accountability.', 'image' => $disasterImages['logistics'], 'href' => '/profil/struktur-gerak'],
            ['label' => 'Resource Governance', 'title' => 'Funds are managed as a collective mandate, not as institutional assets.', 'description' => 'Decisions are made by those closest to crisis so responses are fast, transparent, and relevant to community needs.', 'image' => $disasterImages['waterOne'], 'href' => '/profil/sumber-daya'],
        ];
        $stats = [
            ['value' => '1', 'label' => 'Collective mandate'],
            ['value' => '7', 'label' => 'Regional hubs'],
            ['value' => '33', 'label' => 'Recorded members'],
        ];
        $fieldStories = [
            [
                'title' => 'A Safe Recovery Space for Child Survivors',
                'label' => 'PKBI Aceh',
                'image' => $disasterImages['psychosocial'],
                'description' => 'In a post-disaster situation that still carries trauma, child survivors in Aceh slowly learn to smile, play, and feel safe again through psychosocial support services.',
            ],
            [
                'title' => 'Hope Growing from Children\'s Drawings',
                'label' => 'PKBI Aceh',
                'image' => $disasterImages['children'],
                'description' => 'Through drawing, play, and shared learning activities, children are invited to express their feelings after passing through fear and loss.',
            ],
            [
                'title' => 'Clean Water Access for Affected Communities',
                'label' => 'WALHI Sumut',
                'image' => $disasterImages['waterOne'],
                'description' => 'Installing water tanks is part of a rapid response to ensure basic needs remain met in areas affected by crisis and disrupted services.',
            ],
            [
                'title' => 'Working Together to Prepare Water Facilities',
                'label' => 'WALHI Sumut',
                'image' => $disasterImages['waterTwo'],
                'description' => 'Residents and volunteers work together to prepare clean water facilities. Humanitarian response is stronger when communities are directly involved in recovery.',
            ],
            [
                'title' => 'Logistics Distribution for Disaster Survivors',
                'label' => 'WALHI Sumbar',
                'image' => $disasterImages['logistics'],
                'description' => 'Logistics support is distributed through collective work with volunteers and local hubs so urgent survivor needs can be addressed quickly, transparently, and accurately.',
            ],
        ];
        $principles = ['One CSO one vote', 'Based on community needs', 'Speed as a core value', 'Transparency as a strategic asset', 'Collective accountability', 'Local leadership & local first'];
    }

    $locationCoordinates = [
        'sumbagsel-tangguh' => [3.35, 98.67],
        'yayasan-peduli-kemandirian-masyarakat-yapemmas-medan' => [3.58, 98.67],
        'yayasan-fajar-sejahtera-indonesia-yafsi-medan' => [3.57, 98.65],
        'walhi-sumbar' => [-0.95, 100.35],
        'walhi-sumut' => [3.54, 98.64],
        'flower-aceh' => [5.55, 95.32],
        'yayasan-perempuan-dan-anak-negeri-ypanba-aceh' => [5.51, 95.35],
        'sumbagsel-pulih-lestari' => [-5.43, 105.26],
        'walhi-lampung' => [-5.45, 105.27],
        'lbh-bandar-lampung' => [-5.43, 105.25],
        'pkbi-lampung' => [-5.40, 105.24],
        'walhi-bengkulu' => [-3.80, 102.27],
        'ykws-lampung' => [-5.38, 105.29],
        'tanah-papua' => [-2.53, 140.72],
        'lekat-jayapura' => [-2.54, 140.71],
        'kipra-jayapura' => [-2.57, 140.69],
        'yapmi-jayapura' => [-2.50, 140.74],
        'gemapala-fakfak' => [-2.93, 132.30],
        'yapari-sorong' => [-0.88, 131.25],
        'perdu-manokwari' => [-0.86, 134.06],
        'kompak-nabire' => [-3.36, 135.50],
        'humi-inane-wamena' => [-4.10, 138.95],
        'kalimantan-borneo' => [-1.60, 113.50],
        'walhi-kalbar' => [-0.03, 109.34],
        'walhi-kalsel' => [-3.32, 114.59],
        'walhi-kalteng' => [-2.21, 113.92],
        'walhi-kaltim' => [-0.50, 117.15],
        'elpagar-kalbar' => [-0.06, 109.36],
        'borneo-institute-kalteng' => [-2.23, 113.90],
        'pionir-bulungan-kaltara' => [2.84, 117.37],
        'jawa' => [-7.25, 110.00],
        'walhi-jatim' => [-7.25, 112.75],
        'walhi-jogjakarta' => [-7.80, 110.37],
        'lbh-semarang' => [-6.99, 110.42],
        'lbh-surabaya' => [-7.27, 112.74],
        'lbh-jogjakarta' => [-7.79, 110.36],
        'yayasan-epik' => [-6.90, 107.61],
        'kpi-jabar' => [-6.91, 107.62],
        'sulawesi' => [-2.10, 120.10],
        'bali-nusra' => [-8.65, 117.30],
    ];
    $slugify = fn (string $value): string => strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $value), '-'));
    $mapPoints = [];
    $regionButtons = [];

    foreach (config('cea.simpul_regions', []) as $region) {
        $regionCoordinate = $locationCoordinates[$region['key']] ?? [-2.5, 118.0];
        $regionButtons[] = [
            'key' => $region['key'],
            'label' => $region['shortLabel'],
            'province' => $region['label'],
            'lat' => $regionCoordinate[0],
            'lng' => $regionCoordinate[1],
        ];
        $mapPoints[] = [
            'kind' => 'region',
            'type' => $homeText['hub_type'],
            'region_key' => $region['key'],
            'key' => $region['key'],
            'title' => $region['shortLabel'],
            'description' => $region['label'],
            'lat' => $regionCoordinate[0],
            'lng' => $regionCoordinate[1],
            'url' => "/regio/simpul/{$region['key']}",
        ];

        foreach ($region['members'] ?? [] as $member) {
            $memberKey = $slugify($member);
            $memberCoordinate = $locationCoordinates[$memberKey] ?? $regionCoordinate;
            $mapPoints[] = [
                'kind' => 'member',
                'type' => $homeText['member_type'],
                'region_key' => $region['key'],
                'key' => $memberKey,
                'title' => $member,
                'description' => $region['shortLabel'],
                'lat' => $memberCoordinate[0],
                'lng' => $memberCoordinate[1],
                'url' => "/regio/simpul/{$region['key']}/{$memberKey}",
            ];
        }
    }
@endphp

@push('styles')
<style>
    @import url("https://unpkg.com/leaflet@1.9.4/dist/leaflet.css");
    .cea-landing-hero__grid { align-items: end; display: grid; gap: 48px; grid-template-columns: minmax(0, .86fr) minmax(250px, .5fr); min-height: 390px; position: relative; z-index: 2; }
    .cea-landing-hero__content { max-width: 760px; }
    .cea-landing-hero__eyebrow, .cea-section__head span, .cea-governance-card__body span { color: #f2c94c; display: block; font-size: 12px; font-weight: 900; margin-bottom: 16px; text-transform: uppercase; }
    .cea-landing-hero h1 { color: #fff; font-family: var(--tg-heading-font-family); font-size: clamp(38px, 5.2vw, 76px); font-weight: 900; letter-spacing: 0; line-height: 1.02; margin-bottom: 20px; max-width: 760px; text-shadow: 0 16px 34px rgba(0,0,0,.36); text-transform: none; text-wrap: balance; }
    .cea-landing-hero h1 span { background: transparent; color: #fff; line-height: 1.08; padding: 0; }
    .cea-landing-hero p { color: rgba(255,255,255,.86); font-size: 16px; line-height: 1.75; margin-bottom: 28px; max-width: 620px; }
    .cea-landing-hero__actions { display: flex; flex-wrap: wrap; gap: 12px; }
    .cea-landing-hero__panel { align-self: end; background: rgba(246,249,232,.95); border: 1px solid rgba(255,255,255,.5); border-radius: 8px; color: #063d2a; max-width: 360px; padding: 20px; }
    .cea-landing-hero__panel strong { color: #063d2a; display: block; font-size: 42px; font-weight: 900; line-height: 1; }
    .cea-landing-hero__panel span { color: #1f7a43; font-size: 13px; font-weight: 900; text-transform: uppercase; }
    .cea-landing-hero__panel p { color: rgba(6,61,42,.72); font-size: 14px; line-height: 1.55; margin: 10px 0 0; }
    .cea-section { background: #fff; padding: 82px 0; }
    .cea-section--soft { background: linear-gradient(180deg, #f6f9e8 0%, #fff 100%); }
    .cea-section__head { margin-bottom: 32px; max-width: 820px; }
    .cea-section__head span { color: #1f7a43; margin-bottom: 9px; }
    .cea-section__head h2 { color: #063d2a; font-size: clamp(28px, 3.4vw, 46px); line-height: 1.12; margin: 0; }
    .cea-focus-grid, .cea-menu-grid { display: grid; gap: 22px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .cea-focus-card, .cea-governance-card, .cea-menu-card { background: #fff; border: 1px solid #dfe9c9; border-radius: 8px; box-shadow: 0 18px 44px rgba(6,61,42,.08); overflow: hidden; }
    .cea-focus-card:hover, .cea-governance-card:hover, .cea-menu-card:hover { border-color: rgba(31,122,67,.32); box-shadow: 0 24px 58px rgba(6,61,42,.13); }
    .cea-focus-card__image, .cea-menu-card__image { aspect-ratio: 16 / 10; background: #f6f9e8; overflow: hidden; }
    .cea-focus-card__image img, .cea-menu-card__image img, .cea-governance-card__media img { display: block; height: 100%; object-fit: cover; width: 100%; }
    .cea-focus-card__body, .cea-menu-card__body, .cea-governance-card__body { padding: 24px; }
    .cea-focus-card h3, .cea-governance-card h3, .cea-menu-card h3 { color: #063d2a; font-size: 24px; font-weight: 900; line-height: 1.15; margin-bottom: 12px; }
    .cea-focus-card p, .cea-governance-card p, .cea-menu-card p { color: #4f6759; font-size: 15px; line-height: 1.75; margin: 0; }
    .cea-focus-card__body a { color: #1f7a43; display: inline-flex; font-weight: 900; margin-top: 16px; }
    .cea-principles { background: #fff; padding: 72px 0; }
    .cea-principles__grid { display: grid; gap: 14px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .cea-principle { background: #f6f9e8; border: 1px solid #dfe9c9; border-radius: 8px; color: #063d2a; font-weight: 900; padding: 18px; }
    .cea-field-stories { background: #fbfaf0; padding: 80px 0; }
    .cea-field-stories__grid { display: grid; gap: 22px; grid-template-columns: repeat(6, minmax(0, 1fr)); }
    .cea-story-card { background: #063d2a; border: 1px solid rgba(31,122,67,.16); border-radius: 8px; box-shadow: 0 18px 44px rgba(6,61,42,.08); grid-column: span 2; min-height: 360px; overflow: hidden; position: relative; }
    .cea-story-card:first-child, .cea-story-card:nth-child(2) { grid-column: span 3; }
    .cea-story-card__image { background: #f6f9e8; inset: 0; overflow: hidden; position: absolute; }
    .cea-story-card__image img { display: block; height: 100%; object-fit: cover; width: 100%; }
    .cea-story-card__body { background: linear-gradient(180deg, rgba(6,61,42,.06) 0%, rgba(6,61,42,.94) 100%); bottom: 0; color: #fff; left: 0; padding: 80px 24px 24px; position: absolute; right: 0; z-index: 1; }
    .cea-story-card__label { color: #f2c94c; display: block; font-size: 12px; font-weight: 900; margin-bottom: 10px; text-transform: uppercase; }
    .cea-story-card h3 { color: #fff; font-size: 23px; font-weight: 900; line-height: 1.16; margin-bottom: 12px; text-shadow: 0 8px 20px rgba(0,0,0,.28); }
    .cea-story-card p { color: rgba(255,255,255,.84); display: -webkit-box; font-size: 14px; line-height: 1.65; margin: 0; overflow: hidden; -webkit-box-orient: vertical; -webkit-line-clamp: 3; }
    .cea-stats { background: #063d2a; padding: 40px 0; }
    .cea-stats__grid { display: grid; gap: 18px; grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .cea-stat { border: 1px solid rgba(255,255,255,.16); border-radius: 8px; color: #fff; padding: 22px; }
    .cea-stat strong { color: #f2c94c; display: block; font-size: 48px; font-weight: 900; line-height: 1; margin-bottom: 8px; }
    .cea-stat span { color: rgba(255,255,255,.78); font-size: 14px; font-weight: 800; }
    .cea-governance-grid { display: grid; gap: 24px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .cea-governance-card__media { aspect-ratio: 16 / 10; background: #f6f9e8; overflow: hidden; }
    .cea-governance-card__body span { color: #1f7a43; margin-bottom: 10px; }
    .cea-governance-card__body a, .cea-menu-card__body a { color: #1f7a43; font-weight: 900; }
    .cea-menu-card__body ul { display: grid; gap: 8px; list-style: none; margin: 18px 0 0; padding: 0; }
    .cea-map-section { background: #063d2a; color: #fff; padding: 82px 0; }
    .cea-map-section .cea-section__head h2 { color: #fff; }
    .cea-map-shell { background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.16); border-radius: 8px; overflow: hidden; }
    #simpul-map { background: #0c5266; height: min(72vh, 620px); min-height: 460px; width: 100%; }
    .cea-map-toolbar { align-items: end; display: grid; gap: 18px; grid-template-columns: minmax(0, 1fr) minmax(220px, 260px); margin-bottom: 16px; }
    .cea-map-search { background: #1681a4; border-radius: 8px; padding: 14px; width: min(100%, 260px); }
    .cea-map-search label { color: #fff; display: block; font-size: 12px; font-weight: 900; margin-bottom: 8px; }
    .cea-map-search input { border: 0; border-radius: 4px; min-height: 36px; padding: 8px 10px; width: 100%; }
    .cea-map-search__actions { display: grid; gap: 8px; grid-template-columns: 1fr 1fr; margin-top: 8px; }
    .cea-map-search button, .cea-map-filter button { background: #1c4f78; border: 0; border-radius: 4px; color: #fff; font-size: 11px; font-weight: 900; min-height: 34px; padding: 8px 10px; }
    .cea-map-search button:first-child { background: #7b8893; }
    .cea-map-filter { background: rgba(22,129,164,.82); border: 1px solid rgba(255,255,255,.14); border-radius: 8px; display: grid; gap: 10px; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); margin: 14px auto 0; padding: 12px; position: relative; z-index: 2; }
    .cea-map-filter button { align-items: center; background: #204c78; display: inline-flex; gap: 8px; justify-content: flex-start; line-height: 1.25; text-align: left; }
    .cea-map-filter button::before { background: #f2c94c; border-radius: 999px; content: ""; flex: 0 0 auto; height: 6px; width: 6px; }
    .cea-map-filter button[data-region-all]::before { background: #99ead9; box-shadow: 0 0 0 3px rgba(153,234,217,.24); }
    .cea-map-filter button.is-active { background: #99ead9; color: #063d2a; }
    .simpul-map-marker { align-items: center; border: 3px solid #fff; border-radius: 999px; box-shadow: 0 12px 24px rgba(0,0,0,.25); display: flex; height: 22px; justify-content: center; width: 22px; }
    .simpul-map-marker--region { background: #f2c94c; }
    .simpul-map-marker--member { background: #ff3ab7; height: 16px; width: 16px; }
    .simpul-map-popup strong { color: #063d2a; display: block; font-size: 15px; line-height: 1.25; margin-bottom: 6px; }
    .simpul-map-popup span { color: #1f7a43; display: block; font-size: 12px; font-weight: 900; margin-bottom: 8px; text-transform: uppercase; }
    .simpul-map-popup p { color: #405d4a; font-size: 13px; line-height: 1.45; margin: 0 0 10px; }
    .simpul-map-popup a { align-items: center; background: #1f7a43; border-radius: 6px; color: #fff; display: inline-flex; font-size: 12px; font-weight: 900; min-height: 32px; padding: 8px 11px; }
    .simpul-map-popup a:hover { background: #063d2a; color: #fff; }
    @media (max-width: 1199px) {
        .cea-landing-hero__panel { display: none; }
    }
    @media (max-width: 991px) {
        .cea-landing-hero__grid, .cea-governance-grid { grid-template-columns: 1fr; }
        .cea-focus-grid, .cea-menu-grid, .cea-stats__grid, .cea-principles__grid, .cea-field-stories__grid { grid-template-columns: 1fr; }
        .cea-story-card, .cea-story-card:first-child, .cea-story-card:nth-child(2) { grid-column: auto; }
        .cea-story-card { min-height: 320px; }
        .cea-landing-hero { min-height: 100svh; }
        .cea-map-toolbar { display: block; }
        .cea-map-search { margin-bottom: 14px; width: 100%; }
    }
    @media (max-width: 767px) {
        .cea-landing-hero__grid { align-items: end; gap: 0; min-height: 0; }
        .cea-landing-hero__content { max-width: 100%; }
        .cea-landing-hero__eyebrow { display: none; }
        .cea-landing-hero h1 { font-size: clamp(31px, 11vw, 46px); margin-bottom: 16px; }
        .cea-landing-hero p { font-size: 14px; line-height: 1.65; margin-bottom: 20px; }
        .cea-map-section { padding: 58px 0; }
        #simpul-map { height: 58vh; min-height: 340px; }
        .cea-map-filter { grid-template-columns: 1fr; padding: 10px; }
        .cea-map-filter button { min-height: 40px; }
    }
</style>
@endpush

@section('content')
<section class="cea-video-hero cea-landing-hero">
    <video class="cea-video-hero__video" autoplay muted loop playsinline preload="metadata">
        <source src="{{ $heroVideoSrc }}" type="video/mp4">
    </video>
    <div class="container">
        <div class="cea-landing-hero__grid">
            <div class="cea-landing-hero__content">
                <h1 class="cea-scramble-title"><span>{{ $homeContent['title'] ?? 'Menguatkan lokal, memperluas dampak.' }}</span></h1>
                <p>{{ $homeContent['description'] ?? 'Perubahan besar tidak lahir dari satu lembaga, tapi dari ekosistem yang terhubung. Pooling Fund - KSO menghimpun dan menyalurkan dana kemanusiaan secara bersama, berbasis kebutuhan komunitas dan kepemimpinan lokal, tanpa membentuk badan hukum baru.' }}</p>
                <div class="cea-landing-hero__actions">
                    @if (! empty($homeContent['primary_label']) && ! empty($homeContent['primary_href']))
                        <a class="cea-btn" href="{{ $homeContent['primary_href'] }}">{{ $homeContent['primary_label'] }}</a>
                    @endif
                    @if (! empty($homeContent['secondary_label']) && ! empty($homeContent['secondary_href']))
                        <a class="cea-btn secondary" href="{{ $homeContent['secondary_href'] }}">{{ $homeContent['secondary_label'] }}</a>
                    @endif
                </div>
            </div>
            @if (! empty($homeContent['panel_value']))
                <div class="cea-landing-hero__panel">
                    <span>{{ $homeContent['panel_label'] ?? 'Ekosistem KSO' }}</span>
                    <strong>{{ $homeContent['panel_value'] }}</strong>
                    <p>{{ $homeContent['panel_description'] ?? 'Simpul regional otonom yang terhubung dalam satu mandat kolektif.' }}</p>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="cea-section">
    <div class="container">
        <div class="cea-section__head">
            <span>{{ $homeText['platform_label'] }}</span>
            <h2>{{ $homeText['platform_title'] }}</h2>
        </div>
        <div class="cea-focus-grid">
            @foreach ($focusAreas as $item)
                <article class="cea-focus-card">
                    <div class="cea-focus-card__image">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                    </div>
                    <div class="cea-focus-card__body">
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['description'] }}</p>
                        <a href="{{ $item['href'] }}">{{ $homeText['learn'] }}</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="cea-map-section" id="simpul-map-section">
    <div class="container">
        <div class="cea-section__head">
            <span>{{ $ui['map_label'] ?? 'Peta Simpul' }}</span>
            <h2>{{ $ui['map_title'] ?? 'Jelajahi simpul dan anggota melalui peta interaktif.' }}</h2>
        </div>
        <div class="cea-map-toolbar">
            <div></div>
            <form class="cea-map-search" id="simpul-map-search">
                <label for="simpul-province-search">{{ $ui['search_province'] ?? 'Search Province' }}</label>
                <input id="simpul-province-search" type="search" placeholder="{{ $ui['province_placeholder'] ?? 'Enter province name...' }}">
                <div class="cea-map-search__actions">
                    <button type="button" data-map-reset>{{ $ui['back'] ?? 'Kembali' }}</button>
                    <button type="submit">{{ $ui['search'] ?? 'Search' }}</button>
                </div>
            </form>
        </div>
        <div class="cea-map-shell">
            <div id="simpul-map" data-points='@json($mapPoints)'></div>
        </div>
        <div class="cea-map-filter" aria-label="{{ $ui['map_label'] ?? 'Peta Simpul' }}">
            <button type="button" class="is-active" data-map-reset data-region-all>{{ $ui['all_hubs'] ?? 'Semua Simpul' }}</button>
            @foreach ($regionButtons as $regionButton)
                <button type="button" data-region="{{ $regionButton['key'] }}" data-lat="{{ $regionButton['lat'] }}" data-lng="{{ $regionButton['lng'] }}">{{ $regionButton['label'] }}</button>
            @endforeach
        </div>
    </div>
</section>

@include('partials.news-columns', ['newsArticles' => $latestUpdates ?? collect(), 'newsFallbackImages' => array_values($disasterImages)])

<section class="cea-stats">
    <div class="container">
        <div class="cea-stats__grid">
            @foreach ($stats as $item)
                <div class="cea-stat"><strong>{{ $item['value'] }}</strong><span>{{ $item['label'] }}</span></div>
            @endforeach
        </div>
    </div>
</section>

<section class="cea-principles">
    <div class="container">
        <div class="cea-section__head">
            <span>{{ $homeText['principles_label'] }}</span>
            <h2>{{ $homeText['principles_title'] }}</h2>
        </div>
        <div class="cea-principles__grid">
            @foreach ($principles as $principle)
                <div class="cea-principle">{{ $principle }}</div>
            @endforeach
        </div>
    </div>
</section>

<section class="cea-section cea-section--soft">
    <div class="container">
        <div class="cea-section__head">
            <span>{{ $homeText['governance_label'] }}</span>
            <h2>{{ $homeText['governance_title'] }}</h2>
        </div>
        <div class="cea-governance-grid">
            @foreach ($governanceItems as $item)
                <article class="cea-governance-card">
                    <div class="cea-governance-card__media">
                        <img src="{{ $item['image'] }}" alt="{{ $item['label'] }}">
                    </div>
                    <div class="cea-governance-card__body">
                        <span>{{ $item['label'] }}</span>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['description'] }}</p>
                        <a href="{{ $item['href'] }}">{{ $homeText['read_more'] }}</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="cea-field-stories">
    <div class="container">
        <div class="cea-section__head">
            <span>{{ $homeText['stories_label'] }}</span>
            <h2>{{ $homeText['stories_title'] }}</h2>
        </div>
        <div class="cea-field-stories__grid">
            @foreach ($fieldStories as $story)
                <article class="cea-story-card">
                    <div class="cea-story-card__image">
                        <img src="{{ $story['image'] }}" alt="{{ $story['title'] }}">
                    </div>
                    <div class="cea-story-card__body">
                        <span class="cea-story-card__label">{{ $story['label'] }}</span>
                        <h3>{{ $story['title'] }}</h3>
                        <p>{{ $story['description'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var mapElement = document.getElementById('simpul-map');
        if (!mapElement || !window.L) return;

        var points = [];
        try {
            points = JSON.parse(mapElement.dataset.points || '[]');
        } catch (error) {
            points = [];
        }

        if (!points.length) return;

        var map = L.map(mapElement, {
            scrollWheelZoom: false,
            worldCopyJump: true
        }).setView([-2.5, 118], 5);
        var escapeHtml = function (value) {
            return String(value || '').replace(/[&<>"']/g, function (character) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                }[character];
            });
        };

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 12
        }).addTo(map);

        var bounds = [];
        var markers = [];
        var openPageLabel = @json($ui['open_page'] ?? 'Buka halaman');

        points.forEach(function (point) {
            var markerClass = point.kind === 'region' ? 'simpul-map-marker--region' : 'simpul-map-marker--member';
            var icon = L.divIcon({
                className: '',
                html: '<span class="simpul-map-marker ' + markerClass + '"></span>',
                iconSize: point.kind === 'region' ? [22, 22] : [16, 16],
                iconAnchor: point.kind === 'region' ? [11, 11] : [8, 8]
            });
            var latLng = [point.lat, point.lng];
            var popup = '<div class="simpul-map-popup">'
                + '<span>' + escapeHtml(point.type) + '</span>'
                + '<strong>' + escapeHtml(point.title) + '</strong>'
                + '<p>' + escapeHtml(point.description) + '</p>'
                + '<a href="' + escapeHtml(point.url) + '">' + escapeHtml(openPageLabel) + '</a>'
                + '</div>';

            var marker = L.marker(latLng, { icon: icon, title: point.title })
                .addTo(map)
                .bindPopup(popup, { maxWidth: 260 });

            markers.push({ marker: marker, point: point, latLng: latLng });
            bounds.push(latLng);
        });

        if (bounds.length > 1) {
            map.fitBounds(bounds, { padding: [34, 34] });
        }

        function fitMarkerSet(items) {
            if (!items.length) return;

            if (items.length === 1) {
                map.setView(items[0].latLng, 8);
                items[0].marker.openPopup();
                return;
            }

            map.fitBounds(items.map(function (item) { return item.latLng; }), { padding: [42, 42] });
        }

        var filterButtons = Array.prototype.slice.call(document.querySelectorAll('.cea-map-filter button'));

        document.querySelectorAll('[data-region]').forEach(function (button) {
            button.addEventListener('click', function () {
                filterButtons.forEach(function (item) {
                    item.classList.remove('is-active');
                });
                button.classList.add('is-active');

                var regionItems = markers.filter(function (item) {
                    return item.point.region_key === button.dataset.region;
                });

                fitMarkerSet(regionItems);
            });
        });

        var searchForm = document.getElementById('simpul-map-search');
        var searchInput = document.getElementById('simpul-province-search');
        var resetButtons = Array.prototype.slice.call(document.querySelectorAll('[data-map-reset]'));

        if (searchForm && searchInput) {
            searchForm.addEventListener('submit', function (event) {
                event.preventDefault();
                var query = searchInput.value.trim().toLowerCase();
                if (!query) return;

                var result = markers.filter(function (item) {
                    return [item.point.title, item.point.description, item.point.key, item.point.region_key]
                        .join(' ')
                        .toLowerCase()
                        .indexOf(query) !== -1;
                });

                fitMarkerSet(result);
            });
        }

        if (resetButtons.length) {
            resetButtons.forEach(function (resetButton) {
                resetButton.addEventListener('click', function () {
                    filterButtons.forEach(function (item) {
                        item.classList.remove('is-active');
                    });
                    var allButton = document.querySelector('[data-region-all]');
                    if (allButton) allButton.classList.add('is-active');
                    if (searchInput) searchInput.value = '';
                    if (bounds.length > 1) map.fitBounds(bounds, { padding: [34, 34] });
                });
            });
        }
    });
</script>
@endpush
