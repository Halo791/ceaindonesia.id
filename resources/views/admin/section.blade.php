@extends('layouts.app')

@section('title', 'Admin '.$section['label'])

@php
    $isHomepage = $section['key'] === 'beranda';
    $homeMeta = $content['meta'] ?? [];
    $metaValue = function (string $key, string $fallback = '') use ($homeMeta) {
        return old("meta.{$key}", $homeMeta[$key] ?? $fallback);
    };
    $imagePreviewSrc = function (string $path): string {
        $path = trim($path);

        if ($path === '') {
            return '';
        }

        if (stripos($path, 'drive.google.com') !== false) {
            if (preg_match('~/file/d/([^/?#]+)~', $path, $matches) || preg_match('~[?&]id=([^&#]+)~', $path, $matches)) {
                return 'https://drive.google.com/thumbnail?id='.rawurlencode($matches[1]).'&sz=w800';
            }
        }

        return preg_match('/^https?:\/\//', $path) ? $path : asset(ltrim($path, '/'));
    };
@endphp

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeSection' => $section['key']])
        <div class="admin-workspace">
        <div class="admin-hero">
            <div>
                <span class="admin-eyebrow">Panel Admin Pooling Fund - KSO</span>
                <h1>Kelola {{ $section['label'] }}</h1>
                <p>{{ $section['description'] }}</p>
            </div>
            <!-- <a class="admin-source-link" href="{{ $section['sourceHref'] }}" target="_blank" rel="noreferrer">Sumber resmi</a> -->
        </div>

        <div class="admin-stat-strip">
            <div class="admin-stat"><span>Tipe</span><strong>{{ empty($section['children']) ? 'Menu' : 'Dropdown' }}</strong></div>
            <div class="admin-stat"><span>Subhalaman</span><strong>{{ count($section['children'] ?? []) ?: 1 }}</strong></div>
            <div class="admin-stat"><span>Bahasa</span><strong>ID / EN</strong></div>
            <div class="admin-stat"><span>Status</span><strong>Aktif</strong></div>
        </div>

        <div class="admin-form-card admin-section-spacer">
            <h2>{{ $isHomepage ? 'Pengaturan Halaman Beranda' : 'Form Konten Menu '.$section['label'] }}</h2>
            @if (! $dbReady)
                <div class="alert alert-warning">Tabel <strong>admin_contents</strong> belum tersedia. Import <code>database/sql/admin_contents.sql</code> di phpMyAdmin.</div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @error('database')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <form method="POST" action="{{ $formAction }}">
                @csrf
                <div class="admin-field">
                    <label>{{ $isHomepage ? 'Judul hero beranda' : 'Judul menu' }}</label>
                    <input name="title" value="{{ old('title', $content['title']) }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="admin-field">
                    <label>{{ $isHomepage ? 'Tulisan kecil di atas judul' : 'Subtitle / Ringkasan' }}</label>
                    <input name="subtitle" value="{{ old('subtitle', $content['subtitle']) }}">
                </div>
                <div class="admin-field">
                    <label>{{ $isHomepage ? 'Deskripsi hero beranda' : 'Isi tulisan' }}</label>
                    <textarea name="body">{{ old('body', $content['body']) }}</textarea>
                </div>
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>{{ $isHomepage ? 'Hero title EN' : 'Judul menu EN' }}</label>
                        <input name="meta[title_en]" value="{{ $metaValue('title_en') }}" placeholder="English title">
                    </div>
                    <div class="admin-field">
                        <label>{{ $isHomepage ? 'Hero eyebrow EN' : 'Subtitle / ringkasan EN' }}</label>
                        <input name="meta[subtitle_en]" value="{{ $metaValue('subtitle_en') }}" placeholder="English subtitle">
                    </div>
                </div>
                <div class="admin-field">
                    <label>{{ $isHomepage ? 'Deskripsi hero EN' : 'Isi tulisan EN' }}</label>
                    <textarea name="meta[body_en]" placeholder="English content">{{ $metaValue('body_en') }}</textarea>
                </div>
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>Instagram</label>
                        <input name="meta[social_instagram]" value="{{ $metaValue('social_instagram') }}" placeholder="https://instagram.com/...">
                    </div>
                    <div class="admin-field">
                        <label>Facebook</label>
                        <input name="meta[social_facebook]" value="{{ $metaValue('social_facebook') }}" placeholder="https://facebook.com/...">
                    </div>
                    <div class="admin-field">
                        <label>YouTube</label>
                        <input name="meta[social_youtube]" value="{{ $metaValue('social_youtube') }}" placeholder="https://youtube.com/...">
                    </div>
                    <div class="admin-field">
                        <label>Threads</label>
                        <input name="meta[social_threads]" value="{{ $metaValue('social_threads') }}" placeholder="https://threads.net/@...">
                    </div>
                </div>
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>Link gambar QRIS donasi</label>
                        <input name="meta[qris_image_path]" value="{{ $metaValue('qris_image_path') }}" placeholder="https://drive.google.com/file/d/.../view atau https://...">
                    </div>
                    <div class="admin-field">
                        <label>Nama penerima QRIS</label>
                        <input name="meta[qris_recipient]" value="{{ $metaValue('qris_recipient') }}" placeholder="Nama lembaga / simpul">
                    </div>
                    <div class="admin-field">
                        <label>Judul modal donasi</label>
                        <input name="meta[qris_title]" value="{{ $metaValue('qris_title') }}" placeholder="Donasi untuk ...">
                    </div>
                    <div class="admin-field">
                        <label>Judul modal donasi EN</label>
                        <input name="meta[qris_title_en]" value="{{ $metaValue('qris_title_en') }}" placeholder="Donate to ...">
                    </div>
                </div>
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>Deskripsi modal donasi</label>
                        <textarea name="meta[qris_body]" placeholder="Ajakan singkat untuk donasi">{{ $metaValue('qris_body') }}</textarea>
                    </div>
                    <div class="admin-field">
                        <label>Deskripsi modal donasi EN</label>
                        <textarea name="meta[qris_body_en]" placeholder="Short donation message">{{ $metaValue('qris_body_en') }}</textarea>
                    </div>
                    <div class="admin-field">
                        <label>Catatan QRIS</label>
                        <textarea name="meta[qris_note]" placeholder="Instruksi cek penerima / nominal">{{ $metaValue('qris_note') }}</textarea>
                    </div>
                    <div class="admin-field">
                        <label>Catatan QRIS EN</label>
                        <textarea name="meta[qris_note_en]" placeholder="Recipient / amount instruction">{{ $metaValue('qris_note_en') }}</textarea>
                    </div>
                </div>
                <div class="admin-field">
                    <label>Alt text gambar QRIS</label>
                    <input name="meta[qris_image_alt]" value="{{ $metaValue('qris_image_alt') }}" placeholder="QRIS donasi nama simpul">
                </div>
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>Opsi transfer bank</label>
                        <textarea name="meta[donation_bank_accounts]" placeholder="BCA | 1234567890 | Nama Rekening | Catatan opsional&#10;Mandiri | 9876543210 | Nama Rekening">{{ $metaValue('donation_bank_accounts') }}</textarea>
                    </div>
                    <div class="admin-field">
                        <label>Opsi donasi lainnya</label>
                        <textarea name="meta[donation_other_methods]" placeholder="PayPal | paypal.me/nama&#10;Konfirmasi WhatsApp | +62...">{{ $metaValue('donation_other_methods') }}</textarea>
                    </div>
                </div>
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>Alamat kontak footer</label>
                        <textarea name="meta[contact_address]" placeholder="Alamat sekretariat / simpul">{{ $metaValue('contact_address') }}</textarea>
                    </div>
                    <div class="admin-field">
                        <label>Alamat kontak footer EN</label>
                        <textarea name="meta[contact_address_en]" placeholder="Address for English page">{{ $metaValue('contact_address_en') }}</textarea>
                    </div>
                    <div class="admin-field">
                        <label>Email kontak footer</label>
                        <input name="meta[contact_email]" value="{{ $metaValue('contact_email') }}" placeholder="email@domain.org">
                    </div>
                    <div class="admin-field">
                        <label>Telepon / WhatsApp footer</label>
                        <input name="meta[contact_phone]" value="{{ $metaValue('contact_phone') }}" placeholder="+62...">
                    </div>
                </div>
                <div class="admin-field">
                    <label>{{ $isHomepage ? 'Link Google Drive / path video background' : 'URL / path gambar' }}</label>
                    @php
                        $previewImagePath = (string) old('image_path', $content['image_path']);
                        $previewFallbackImage = asset('assets/img/lapangan/walhi-sumut-tandon-air-1.jpeg');
                        $previewImageSrc = ($previewImagePath && strpos($previewImagePath, 'assets/img/cea/') !== false) ? $previewFallbackImage : $previewImagePath;
                        $previewVideoPath = $previewImagePath;
                        if (stripos($previewVideoPath, "drive.google.com") !== false) {
                            $previewDriveId = null;
                            if (preg_match("~/file/d/([^/]+)~", $previewVideoPath, $previewDriveMatches)) {
                                $previewDriveId = $previewDriveMatches[1];
                            } else {
                                parse_str((string) parse_url($previewVideoPath, PHP_URL_QUERY), $previewDriveParams);
                                $previewDriveId = $previewDriveParams["id"] ?? null;
                            }
                            if (filled($previewDriveId)) {
                                $previewVideoPath = "https://drive.google.com/uc?export=download&id=".rawurlencode($previewDriveId);
                            }
                        }
                        $previewVideoSrc = ($previewVideoPath && preg_match("/^https?:\/\//", $previewVideoPath)) ? $previewVideoPath : asset(ltrim($previewVideoPath, "/"));
                    @endphp
                    <input name="image_path" value="{{ $previewImagePath }}" placeholder="{{ $isHomepage ? 'https://drive.google.com/file/d/FILE_ID/view atau /assets/img/cea/video.mp4' : 'Kosongkan untuk foto lapangan otomatis atau gunakan https://...' }}">
                    @if ($isHomepage && ! empty($previewImagePath))
                        <video src="{{ $previewVideoSrc }}" autoplay muted loop playsinline style="border-radius:8px;margin-top:12px;max-height:190px;object-fit:cover;width:100%;"></video>
                    @elseif (! empty($previewImageSrc))
                        <img src="{{ $previewImageSrc }}" alt="{{ $content['title'] }}" style="border-radius:8px;margin-top:12px;max-height:180px;object-fit:cover;width:100%;">
                    @endif
                </div>
                @unless ($isHomepage)
                    <div class="admin-grid" style="margin-bottom:16px;">
                        <div class="admin-field">
                            <label>Video background halaman</label>
                            <input name="meta[hero_video_path]" value="{{ $metaValue('hero_video_path') }}" placeholder="https://drive.google.com/file/d/.../view atau /assets/img/cea/video.mp4">
                            <small>Opsional. Jika diisi, video ini menjadi background hero menu ini. Jika kosong, halaman memakai gambar di atas.</small>
                        </div>
                        <div class="admin-field">
                            <label>Logo header halaman</label>
                            <input name="meta[header_logo_path]" value="{{ $metaValue('header_logo_path') }}" placeholder="https://.../logo.png atau /assets/img/...">
                            <small>Opsional. Logo ini tampil di header hanya pada menu ini.</small>
                        </div>
                    </div>
                @endunless
                @if ($isHomepage)
                    <input type="hidden" name="source_href" value="{{ old('source_href', $content['source_href']) }}">
                    <div class="admin-grid" style="margin-bottom:16px;">
                        <div class="admin-field">
                            <label>Label tombol utama</label>
                            <input name="meta[primary_label]" value="{{ $metaValue('primary_label') }}">
                        </div>
                        <div class="admin-field">
                            <label>Label tombol utama EN</label>
                            <input name="meta[primary_label_en]" value="{{ $metaValue('primary_label_en') }}">
                        </div>
                        <div class="admin-field">
                            <label>URL tombol utama</label>
                            <input name="meta[primary_href]" value="{{ $metaValue('primary_href') }}">
                        </div>
                        <div class="admin-field">
                            <label>Label tombol kedua</label>
                            <input name="meta[secondary_label]" value="{{ $metaValue('secondary_label') }}">
                        </div>
                        <div class="admin-field">
                            <label>Label tombol kedua EN</label>
                            <input name="meta[secondary_label_en]" value="{{ $metaValue('secondary_label_en') }}">
                        </div>
                        <div class="admin-field">
                            <label>URL tombol kedua</label>
                            <input name="meta[secondary_href]" value="{{ $metaValue('secondary_href') }}">
                        </div>
                        <div class="admin-field">
                            <label>Label panel angka</label>
                            <input name="meta[panel_label]" value="{{ $metaValue('panel_label') }}">
                        </div>
                        <div class="admin-field">
                            <label>Label panel angka EN</label>
                            <input name="meta[panel_label_en]" value="{{ $metaValue('panel_label_en') }}">
                        </div>
                        <div class="admin-field">
                            <label>Angka panel</label>
                            <input name="meta[panel_value]" value="{{ $metaValue('panel_value') }}">
                        </div>
                    </div>
                    <div class="admin-field">
                        <label>Deskripsi panel angka</label>
                        <input name="meta[panel_description]" value="{{ $metaValue('panel_description') }}">
                    </div>
                    <div class="admin-field">
                        <label>Deskripsi panel angka EN</label>
                        <input name="meta[panel_description_en]" value="{{ $metaValue('panel_description_en') }}">
                    </div>
                    <fieldset style="border:1px solid rgba(31,122,67,.16);border-radius:8px;margin:24px 0 16px;padding:18px;">
                        <legend style="font-size:22px;font-weight:900;padding:0 8px;">Cerita Lapangan</legend>
                        <p style="color:#68796f;margin-bottom:18px;">Ubah gambar dan teks kartu foto pada bagian bawah halaman beranda.</p>
                        @foreach (range(1, 5) as $storyNumber)
                            @php
                                $storyImagePath = (string) $metaValue("field_story_{$storyNumber}_image");
                                $storyGdrivePath = (string) $metaValue("field_story_{$storyNumber}_gdrive");
                                $storyPreviewSrc = $imagePreviewSrc($storyGdrivePath ?: $storyImagePath);
                            @endphp
                            <fieldset style="background:#fbfaf0;border:1px solid rgba(31,122,67,.12);border-radius:8px;margin-bottom:16px;padding:18px;">
                                <legend style="font-size:18px;font-weight:900;padding:0 8px;">Kartu {{ $storyNumber }}</legend>
                                <div class="admin-grid" style="margin-bottom:16px;">
                                    <div class="admin-field">
                                        <label>Judul</label>
                                        <input name="meta[field_story_{{ $storyNumber }}_title]" value="{{ $metaValue("field_story_{$storyNumber}_title") }}">
                                    </div>
                                    <div class="admin-field">
                                        <label>Judul EN</label>
                                        <input name="meta[field_story_{{ $storyNumber }}_title_en]" value="{{ $metaValue("field_story_{$storyNumber}_title_en") }}">
                                    </div>
                                    <div class="admin-field">
                                        <label>Label simpul</label>
                                        <input name="meta[field_story_{{ $storyNumber }}_label]" value="{{ $metaValue("field_story_{$storyNumber}_label") }}">
                                    </div>
                                    <div class="admin-field">
                                        <label>Label simpul EN</label>
                                        <input name="meta[field_story_{{ $storyNumber }}_label_en]" value="{{ $metaValue("field_story_{$storyNumber}_label_en") }}">
                                    </div>
                                </div>
                                <div class="admin-field">
                                    <label>URL / path gambar</label>
                                    <input name="meta[field_story_{{ $storyNumber }}_image]" value="{{ $storyImagePath }}" placeholder="/assets/img/lapangan/foto.jpeg atau https://...">
                                </div>
                                <div class="admin-field">
                                    <label>Link Google Drive gambar</label>
                                    <input name="meta[field_story_{{ $storyNumber }}_gdrive]" value="{{ $storyGdrivePath }}" placeholder="https://drive.google.com/file/d/FILE_ID/view">
                                    @if ($storyPreviewSrc)
                                        <img src="{{ $storyPreviewSrc }}" alt="Preview kartu {{ $storyNumber }}" style="border-radius:8px;margin-top:12px;max-height:180px;object-fit:cover;width:100%;">
                                    @endif
                                </div>
                                <div class="admin-grid" style="margin-bottom:0;">
                                    <div class="admin-field">
                                        <label>Deskripsi</label>
                                        <textarea name="meta[field_story_{{ $storyNumber }}_description]">{{ $metaValue("field_story_{$storyNumber}_description") }}</textarea>
                                    </div>
                                    <div class="admin-field">
                                        <label>Deskripsi EN</label>
                                        <textarea name="meta[field_story_{{ $storyNumber }}_description_en]">{{ $metaValue("field_story_{$storyNumber}_description_en") }}</textarea>
                                    </div>
                                </div>
                            </fieldset>
                        @endforeach
                    </fieldset>
                @else
                    <div class="admin-field">
                        <label>URL sumber</label>
                        <input name="source_href" value="{{ old('source_href', $content['source_href']) }}">
                    </div>
                    <div class="admin-field">
                        <label>URL sumber EN (opsional)</label>
                        <input name="meta[source_href_en]" value="{{ $metaValue('source_href_en') }}">
                    </div>
                @endif
                <div class="admin-field">
                    <label>Status publikasi</label>
                    <select name="status">
                        <option value="draft" @selected(old('status', $content['status']) === 'draft')>Draft</option>
                        <option value="active" @selected(old('status', $content['status']) === 'active')>Aktif</option>
                        <option value="archived" @selected(old('status', $content['status']) === 'archived')>Arsip</option>
                    </select>
                </div>
                <div class="admin-form-actions">
                    <button class="admin-button" type="submit">Simpan ke database</button>
                    <a class="admin-button secondary" href="{{ $content['source_href'] ?: $section['sourceHref'] }}" target="_blank" rel="noreferrer">Lihat sumber</a>
                </div>
            </form>
        </div>

        @if (! empty($section['children']))
            <div class="admin-grid">
                @foreach ($section['children'] as $item)
                    <article class="admin-card">
                        <span class="admin-card__label">{{ $section['label'] }}</span>
                        <h2>{{ $item['label'] }}</h2>
                        <p>{{ $item['description'] }}</p>
                        <div class="admin-card__actions">
                            <a class="admin-button" href="{{ route('admin.item', [$section['key'], $item['key']]) }}">Kelola halaman</a>
                            <a class="admin-button secondary" href="{{ $item['sourceHref'] }}" target="_blank" rel="noreferrer">Sumber</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
        </div>
    </div>
</section>
@endsection
