@extends('layouts.app')

@section('title', 'Admin '.$item['label'])

@php
    $contentMeta = $content['meta'] ?? [];
    $metaValue = function (string $key, string $fallback = '') use ($contentMeta) {
        return old("meta.{$key}", $contentMeta[$key] ?? $fallback);
    };
@endphp

@section('content')
<section class="cea-admin-panel">
    <div class="admin-shell">
        @include('admin.partials.sidebar', ['activeSection' => $section['key'], 'activeItemKey' => $contentKey])
        <div class="admin-workspace">
        <div class="admin-hero">
            <div>
                <span class="admin-eyebrow">{{ $section['label'] }}</span>
                <h1>Kelola {{ $item['label'] }}</h1>
                <p>{{ $item['description'] }}</p>
            </div>
            {{-- <a class="admin-source-link" href="{{ $item['sourceHref'] ?? $item['publicHref'] ?? '#' }}" target="_blank" rel="noreferrer">Sumber resmi</a> --}}
        </div>

        <div class="admin-form-card admin-section-spacer">
            <h2>Form Konten Database</h2>
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
                    <label>Judul halaman</label>
                    <input name="title" value="{{ old('title', $content['title']) }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="admin-field">
                    <label>Subtitle / Ringkasan</label>
                    <input name="subtitle" value="{{ old('subtitle', $content['subtitle']) }}">
                </div>
                <div class="admin-field">
                    <label>Isi tulisan</label>
                    <textarea name="body">{{ old('body', $content['body']) }}</textarea>
                </div>
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>Judul halaman EN</label>
                        <input name="meta[title_en]" value="{{ $metaValue('title_en') }}" placeholder="English title">
                    </div>
                    <div class="admin-field">
                        <label>Subtitle / ringkasan EN</label>
                        <input name="meta[subtitle_en]" value="{{ $metaValue('subtitle_en') }}" placeholder="English subtitle">
                    </div>
                </div>
                <div class="admin-field">
                    <label>Isi tulisan EN</label>
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
                        <input name="meta[qris_recipient]" value="{{ $metaValue('qris_recipient') }}" placeholder="Nama lembaga / anggota">
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
                    <input name="meta[qris_image_alt]" value="{{ $metaValue('qris_image_alt') }}" placeholder="QRIS donasi nama anggota">
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
                    <label>URL / path gambar</label>
                    @php
                        $previewImagePath = old('image_path', $content['image_path']);
                        $previewFallbackImage = asset('assets/img/lapangan/walhi-sumbar-distribusi-logistik.jpeg');
                        $previewImageSrc = ($previewImagePath && strpos($previewImagePath, 'assets/img/cea/') !== false) ? $previewFallbackImage : $previewImagePath;
                    @endphp
                    <input name="image_path" value="{{ $previewImagePath }}" placeholder="Kosongkan untuk foto lapangan otomatis atau gunakan https://...">
                    @if (! empty($previewImageSrc))
                        <img src="{{ $previewImageSrc }}" alt="{{ $content['title'] }}" style="border-radius:8px;margin-top:12px;max-height:180px;object-fit:cover;width:100%;">
                    @endif
                </div>
                <div class="admin-grid" style="margin-bottom:16px;">
                    <div class="admin-field">
                        <label>Video background halaman</label>
                        <input name="meta[hero_video_path]" value="{{ $metaValue('hero_video_path') }}" placeholder="https://drive.google.com/file/d/.../view atau /assets/img/cea/video.mp4">
                        <small>Opsional. Jika diisi, video ini menjadi background hero halaman ini. Jika kosong, halaman memakai gambar di atas.</small>
                    </div>
                    <div class="admin-field">
                        <label>Logo header halaman</label>
                        <input name="meta[header_logo_path]" value="{{ $metaValue('header_logo_path') }}" placeholder="https://.../logo.png atau /assets/img/...">
                        <small>Opsional. Logo ini tampil di header hanya pada halaman ini dan artikel milik halaman ini.</small>
                    </div>
                </div>
                <div class="admin-field">
                    <label>URL sumber</label>
                    <input name="source_href" value="{{ old('source_href', $content['source_href']) }}">
                </div>
                <div class="admin-field">
                    <label>URL sumber EN (opsional)</label>
                    <input name="meta[source_href_en]" value="{{ $metaValue('source_href_en') }}">
                </div>
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
                    <a class="admin-button secondary" href="{{ $content['source_href'] ?: ($item['sourceHref'] ?? $item['publicHref'] ?? '#') }}" target="_blank" rel="noreferrer">Lihat sumber</a>
                </div>
            </form>
        </div>
        @if (! empty($item['children']))
            <div class="admin-grid admin-section-spacer">
                @foreach ($item['children'] as $child)
                    <article class="admin-card">
                        <span class="admin-card__label">{{ $item['label'] }}</span>
                        <h2>{{ $child['label'] }}</h2>
                        <p>{{ $child['description'] }}</p>
                        <div class="admin-card__actions">
                            <a class="admin-button" href="{{ $child['href'] ?? '#' }}">Kelola halaman</a>
                            @if (! empty($child['sourceHref']))
                                <a class="admin-button secondary" href="{{ $child['sourceHref'] }}" target="_blank" rel="noreferrer">Sumber</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
        </div>
    </div>
</section>
@endsection
