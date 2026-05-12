import CeaLeafletMap from "@/components/elements/CeaLeafletMap"
import Layout from "@/components/layout/Layout"
import { ceaNavigation, dropdownSections, getPublicHref } from "@/util/ceaNavigation"
import Link from "next/link"
import { useEffect, useRef } from "react"

const images = {
    header: "/assets/img/cea/campur.png",
    collective: "/assets/img/cea/campur.png",
    governance: "/assets/img/cea/tatakelola.png",
    structure: "/assets/img/cea/struktur_gerak.png",
    forum: "/assets/img/cea/pomelli_bdna_image_0510%20%285%29.png",
    action: "/assets/img/cea/pomelli_bdna_image_0510%20%286%29.png",
    study: "/assets/img/cea/pomelli_bdna_image_0510%20%287%29.png",
}

const focusAreas = [
    {
        title: "Ruang Sipil",
        description: "Mengawal ruang aman bagi organisasi masyarakat sipil, komunitas, dan warga.",
        image: images.action,
    },
    {
        title: "Gerakan Kolektif",
        description: "Menghubungkan simpul, gagasan, dan aksi lintas wilayah agar gerakan tetap relevan.",
        image: images.collective,
    },
    {
        title: "Diskursus Publik",
        description: "Membuka ruang belajar, refleksi, dan pertukaran strategi antaraktor masyarakat sipil.",
        image: images.forum,
    },
]

const governanceItems = [
    {
        label: "Struktur Gerak",
        title: "Simpul, gugus tugas, dan kaukus isu yang saling terhubung.",
        description: "Struktur Pooling Fund - KSO bergerak sebagai jejaring regional dan nasional yang bekerja otonom namun tetap terikat tujuan bersama.",
        image: images.structure,
        href: "/admin/profil/struktur-gerak",
    },
    {
        label: "Tata Kelola",
        title: "Mobilisasi sumber daya dikelola lewat simpul dan platform penyaluran dana.",
        description: "Bagian tata kelola pada landing page memakai gambar tatakelola.png sesuai aset yang tersedia di direktori Pooling Fund - KSO.",
        image: images.governance,
        href: "/admin/profil/sumber-daya",
    },
]

const stats = [
    { value: "78", label: "Organisasi masyarakat sipil" },
    { value: "19", label: "Provinsi jejaring" },
    { value: "6", label: "Simpul regional" },
]

const sectionImage = {
    profil: images.structure,
    regio: images.collective,
    siar: images.forum,
    aksi: images.study,
    koneksi: images.governance,
}

const footerAdminLinks = [
    { label: "Struktur Gerak", href: "/admin/profil/struktur-gerak" },
    { label: "Tata Kelola", href: "/admin/profil/sumber-daya" },
    { label: "Siar Kabar", href: "/admin/siar/kabar" },
    { label: "Koneksi", href: "/admin/koneksi" },
]

const heroTitle = "Merawat ruang sipil, memperkuat gerakan akar rumput."

function ScrambleHeroTitle() {
    const titleRef = useRef(null)

    useEffect(() => {
        let animation
        let animeTools
        let frameId
        let isMounted = true
        let lastRun = 0
        let lastScrollY = window.scrollY
        let lastDirection = "down"

        const isTitleVisible = () => {
            if (!titleRef.current) return false

            const rect = titleRef.current.getBoundingClientRect()
            return rect.top < window.innerHeight * 0.92 && rect.bottom > window.innerHeight * 0.08
        }

        async function runScramble(from = "left", force = false) {
            const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches
            if (prefersReducedMotion || !titleRef.current) return

            const now = performance.now()
            if (!force && now - lastRun < 900) return

            animeTools = animeTools || await import("animejs")
            if (!isMounted || !titleRef.current) return

            const { animate, scrambleText } = animeTools
            lastRun = now
            animation?.cancel?.()
            animation = animate(titleRef.current, {
                textContent: scrambleText({
                    text: heroTitle,
                    chars: "A-Z0-9!%#_+",
                    cursor: "_",
                    duration: 1450,
                    revealRate: 48,
                    settleRate: 24,
                    from,
                    seed: Math.floor(now),
                }),
                duration: 1700,
                ease: "outQuad",
            })
        }

        const handleScroll = () => {
            if (frameId) return

            frameId = window.requestAnimationFrame(() => {
                frameId = null

                const currentScrollY = window.scrollY
                const direction = currentScrollY > lastScrollY ? "down" : "up"
                const distance = Math.abs(currentScrollY - lastScrollY)

                if (distance > 14 && isTitleVisible()) {
                    const from = direction === "down" ? "left" : "right"
                    runScramble(from, direction !== lastDirection)
                    lastDirection = direction
                }

                lastScrollY = currentScrollY
            })
        }

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    runScramble(lastDirection === "down" ? "left" : "right", true)
                }
            },
            { threshold: 0.45 }
        )

        if (titleRef.current) observer.observe(titleRef.current)
        runScramble("left", true)
        window.addEventListener("scroll", handleScroll, { passive: true })

        return () => {
            isMounted = false
            window.removeEventListener("scroll", handleScroll)
            observer.disconnect()
            if (frameId) window.cancelAnimationFrame(frameId)
            animation?.cancel?.()
        }
    }, [])

    return (
        <h1 ref={titleRef} className="cea-scramble-title" aria-label={heroTitle}>
            {heroTitle}
        </h1>
    )
}

export default function Home() {
    return (
        <Layout headerStyle={1} footerStyle={4} headTitle="Pooling Fund - KSO">
            <section className="cea-landing-hero">
                <div className="container">
                    <div className="cea-landing-hero__grid">
                        <div className="cea-landing-hero__content">
                            <span className="cea-landing-hero__eyebrow">KSO Pooling Fund Kemanusiaan</span>
                            <ScrambleHeroTitle />
                            <p>
                                Pooling Fund - KSO adalah aliansi organisasi masyarakat sipil yang bekerja bersama untuk
                                demokrasi, ruang sipil, keadilan sosial, dan kelestarian alam.
                            </p>
                            <div className="cea-landing-hero__actions">
                                <Link className="cea-btn" href="/admin">
                                    Buka Panel Admin
                                </Link>
                                <a className="cea-btn secondary" href="#kontak-kso">
                                    Hubungi Sekretariat
                                </a>
                            </div>
                        </div>

                        <div className="cea-landing-hero__visual" aria-label="Gambar header Pooling Fund - KSO">
                            <img src={images.header} alt="Pooling Fund - KSO" />
                        </div>
                    </div>
                </div>
            </section>

            <section className="cea-section">
                <div className="container">
                    <div className="cea-section__head">
                        <span>Fokus Gerakan</span>
                        <h2>Aliansi yang menghubungkan simpul, gagasan, dan aksi.</h2>
                    </div>
                    <div className="cea-focus-grid">
                        {focusAreas.map((item) => (
                            <article className="cea-focus-card" key={item.title}>
                                <div className="cea-focus-card__image">
                                    <img src={item.image} alt={item.title} />
                                </div>
                                <div className="cea-focus-card__body">
                                    <h3>{item.title}</h3>
                                    <p>{item.description}</p>
                                </div>
                            </article>
                        ))}
                    </div>
                </div>
            </section>

            <section className="cea-stats">
                <div className="container">
                    <div className="cea-stats__grid">
                        {stats.map((item) => (
                            <div className="cea-stat" key={item.label}>
                                <strong>{item.value}</strong>
                                <span>{item.label}</span>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            <section className="cea-section cea-section--soft">
                <div className="container">
                    <div className="cea-section__head">
                        <span>Struktur & Tata Kelola</span>
                        <h2>Gerak kolektif ditopang oleh struktur dan tata kelola sumber daya.</h2>
                    </div>
                    <div className="cea-governance-grid">
                        {governanceItems.map((item) => (
                            <article className="cea-governance-card" key={item.label}>
                                <div className="cea-governance-card__media">
                                    <img src={item.image} alt={item.label} />
                                </div>
                                <div className="cea-governance-card__body">
                                    <span>{item.label}</span>
                                    <h3>{item.title}</h3>
                                    <p>{item.description}</p>
                                    <Link href={item.href}>Kelola di admin</Link>
                                </div>
                            </article>
                        ))}
                    </div>
                </div>
            </section>

            <section className="cea-map-section">
                <div className="container">
                    <div className="cea-map-shell">
                        <div className="cea-section__head">
                            <span>Peta Simpul</span>
                            <h2>Sebaran jaringan Pooling Fund - KSO di berbagai wilayah Indonesia.</h2>
                        </div>
                        <div className="cea-map-layout">
                            <div className="cea-map-copy">
                                <p>
                                    Peta ini memakai Leaflet JS untuk menampilkan gambaran simpul regional,
                                    sekretariat, dan jaringan pendukung yang terhubung dalam ekosistem Pooling Fund - KSO.
                                </p>
                                <div className="cea-map-legend">
                                    <span><i className="is-secretariat" /> Sekretariat</span>
                                    <span><i className="is-regio" /> Simpul Regio</span>
                                    <span><i className="is-network" /> Jaringan</span>
                                </div>
                            </div>
                            <CeaLeafletMap />
                        </div>
                    </div>
                </div>
            </section>

            <section className="cea-section">
                <div className="container">
                    <div className="cea-section__head">
                        <span>Menu & Dropdown</span>
                        <h2>Pooling Fund - KSO Repositori</h2>
                    </div>
                    <div className="cea-menu-grid">
                        {dropdownSections.map((section) => (
                            <article className="cea-menu-card" key={section.key}>
                                <div className="cea-menu-card__image">
                                    <img src={sectionImage[section.key] || images.collective} alt={section.label} />
                                </div>
                                <div className="cea-menu-card__body">
                                    <h3>{section.label}</h3>
                                    <p>{section.description}</p>
                                    <ul>
                                        {section.children.slice(0, 5).map((item) => (
                                            <li key={item.key}>
                                                <Link href={getPublicHref(item)}>{item.label}</Link>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            </article>
                        ))}
                    </div>
                </div>
            </section>

            <footer className="cea-landing-footer" id="kontak-kso">
                <div className="container">
                    <div className="cea-footer-grid">
                        <div className="cea-footer-brand">
                            <img src="/assets/img/cea/1.png" alt="Pooling Fund - KSO" />
                            <p>
                                Aliansi keterlibatan sipil untuk merawat demokrasi, memperkuat ruang sipil,
                                dan menghubungkan kerja kolektif lintas wilayah.
                            </p>
                            <div className="cea-footer-actions">
                                <Link href="/admin">Panel Admin</Link>
                                <a href="#kontak-kso">Kontak</a>
                            </div>
                        </div>
                        <div>
                            <h3>Menu</h3>
                            <ul>
                                {ceaNavigation.map((item) => (
                                    <li key={item.key}>
                                        <Link href={getPublicHref(item)}>{item.label}</Link>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <div>
                            <h3>Kanal Admin</h3>
                            <ul>
                                {footerAdminLinks.map((item) => (
                                    <li key={item.href}>
                                        <Link href={item.href}>{item.label}</Link>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <div>
                            <h3>Kontak</h3>
                            <p>Jl. Patih Singoranu No. 155, Tamanan, Banguntapan, Bantul, DI Yogyakarta.</p>
                            <p>sekretariat@ksopoolingfund.id</p>
                        </div>
                    </div>
                    <div className="cea-footer-bottom">
                        <span>2026 Pooling Fund - KSO</span>
                    </div>
                </div>
            </footer>

            <style jsx>{`
                .cea-landing-hero {
                    background:
                        radial-gradient(circle at 80% 10%, rgba(232, 93, 74, 0.34), transparent 32%),
                        linear-gradient(135deg, #2a0710 0%, #5b0f1a 54%, #7a1626 100%);
                    color: #fff;
                    overflow: hidden;
                    padding: 78px 0 86px;
                }

                .cea-landing-hero__grid {
                    align-items: center;
                    display: grid;
                    gap: 48px;
                    grid-template-columns: minmax(0, 0.82fr) minmax(420px, 1fr);
                }

                .cea-landing-hero__eyebrow,
                .cea-section__head span,
                .cea-governance-card__body span {
                    color: #f2b66d;
                    display: block;
                    font-size: 13px;
                    font-weight: 900;
                    margin-bottom: 18px;
                    text-transform: uppercase;
                }

                .cea-landing-hero h1 {
                    color: #fff;
                    font-family: var(--tg-heading-font-family);
                    font-size: clamp(52px, 6.8vw, 96px);
                    font-weight: 900;
                    letter-spacing: 0;
                    line-height: 0.94;
                    margin-bottom: 22px;
                    max-width: 860px;
                    min-height: 4.75em;
                    text-transform: none;
                    text-wrap: balance;
                }

                .cea-scramble-title {
                    font-variation-settings: "wght" 900;
                    overflow-wrap: anywhere;
                }

                .cea-landing-hero p {
                    color: rgba(255, 255, 255, 0.82);
                    font-size: 18px;
                    line-height: 1.75;
                    margin-bottom: 30px;
                    max-width: 640px;
                }

                .cea-landing-hero__actions,
                .cea-footer-actions {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 12px;
                }

                .cea-btn,
                .cea-footer-actions a {
                    align-items: center;
                    background: #f2b66d;
                    border: 1px solid #f2b66d;
                    border-radius: 8px;
                    color: #2a0710;
                    display: inline-flex;
                    font-size: 14px;
                    font-weight: 800;
                    min-height: 46px;
                    padding: 12px 18px;
                }

                .cea-btn:hover,
                .cea-footer-actions a:hover {
                    background: #fff;
                    border-color: #fff;
                    color: #4b0b17;
                }

                .cea-btn.secondary {
                    background: transparent;
                    border-color: rgba(255, 255, 255, 0.38);
                    color: #fff;
                }

                .cea-btn.secondary:hover {
                    background: #fff;
                    border-color: #fff;
                    color: #4b0b17;
                }

                .cea-landing-hero__visual {
                    align-items: center;
                    background: #fff8f5;
                    border-radius: 8px;
                    box-shadow: 0 34px 80px rgba(42, 7, 16, 0.36);
                    display: flex;
                    min-height: 330px;
                    overflow: hidden;
                    padding: 28px;
                }

                .cea-landing-hero__visual img,
                .cea-focus-card__image img,
                .cea-governance-card__media img,
                .cea-menu-card__image img {
                    display: block;
                    height: auto;
                    width: 100%;
                }

                .cea-section {
                    background: #fff;
                    padding: 76px 0;
                }

                .cea-section--soft {
                    background: #fff4f2;
                }

                .cea-section__head {
                    margin-bottom: 32px;
                    max-width: 820px;
                }

                .cea-section__head span {
                    color: #b91c31;
                    margin-bottom: 9px;
                }

                .cea-section__head h2 {
                    color: #3a0710;
                    font-size: clamp(28px, 3.4vw, 46px);
                    line-height: 1.12;
                    margin: 0;
                }

                .cea-focus-grid,
                .cea-menu-grid {
                    display: grid;
                    gap: 22px;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }

                .cea-focus-card,
                .cea-governance-card,
                .cea-menu-card {
                    background: #fff;
                    border: 1px solid #efd0d0;
                    border-radius: 8px;
                    box-shadow: 0 18px 44px rgba(75, 11, 23, 0.08);
                    overflow: hidden;
                }

                .cea-focus-card__image,
                .cea-menu-card__image {
                    aspect-ratio: 16 / 10;
                    background: #fff4f2;
                    overflow: hidden;
                }

                .cea-focus-card__image img,
                .cea-menu-card__image img {
                    height: 100%;
                    object-fit: cover;
                }

                .cea-focus-card__body,
                .cea-menu-card__body,
                .cea-governance-card__body {
                    padding: 24px;
                }

                .cea-focus-card h3,
                .cea-governance-card h3,
                .cea-menu-card h3 {
                    color: #3a0710;
                    font-size: 24px;
                    font-weight: 900;
                    line-height: 1.15;
                    margin-bottom: 12px;
                }

                .cea-focus-card p,
                .cea-governance-card p,
                .cea-menu-card p,
                .cea-map-copy p,
                .cea-landing-footer p {
                    color: #67464b;
                    font-size: 15px;
                    line-height: 1.75;
                    margin: 0;
                }

                .cea-stats {
                    background: #4b0b17;
                    padding: 40px 0;
                }

                .cea-stats__grid {
                    display: grid;
                    gap: 18px;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }

                .cea-stat {
                    border: 1px solid rgba(255, 255, 255, 0.16);
                    border-radius: 8px;
                    color: #fff;
                    padding: 22px;
                }

                .cea-stat strong {
                    color: #f2b66d;
                    display: block;
                    font-size: 48px;
                    font-weight: 900;
                    line-height: 1;
                    margin-bottom: 8px;
                }

                .cea-stat span {
                    color: rgba(255, 255, 255, 0.78);
                    font-size: 14px;
                    font-weight: 800;
                }

                .cea-governance-grid {
                    display: grid;
                    gap: 24px;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .cea-governance-card__media {
                    background: #fff;
                    padding: 18px;
                }

                .cea-governance-card__body span {
                    color: #b91c31;
                    margin-bottom: 10px;
                }

                .cea-governance-card__body a,
                .cea-menu-card__body a {
                    color: #b91c31;
                    font-weight: 900;
                }

                .cea-map-section {
                    background: linear-gradient(180deg, #fff4f2 0%, #ffffff 100%);
                    padding: 76px 0;
                }

                .cea-map-shell {
                    background: #fff;
                    border: 1px solid #efd0d0;
                    border-radius: 8px;
                    box-shadow: 0 24px 60px rgba(75, 11, 23, 0.08);
                    overflow: hidden;
                    padding: 28px;
                }

                .cea-map-layout {
                    display: grid;
                    gap: 24px;
                    grid-template-columns: minmax(230px, 0.36fr) minmax(0, 1fr);
                }

                .cea-map-copy {
                    align-self: stretch;
                    background: #4b0b17;
                    border-radius: 8px;
                    color: #fff;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    padding: 24px;
                }

                .cea-map-copy p,
                .cea-map-legend span {
                    color: rgba(255, 255, 255, 0.82);
                }

                .cea-map-legend {
                    display: grid;
                    gap: 10px;
                    margin-top: 24px;
                }

                .cea-map-legend span {
                    align-items: center;
                    display: inline-flex;
                    font-size: 13px;
                    font-weight: 800;
                    gap: 9px;
                }

                .cea-map-legend i {
                    border-radius: 999px;
                    display: inline-block;
                    height: 12px;
                    width: 12px;
                }

                .cea-map-legend .is-secretariat { background: #b91c31; }
                .cea-map-legend .is-regio { background: #1677d2; }
                .cea-map-legend .is-network { background: #a26d49; }

                :global(.cea-leaflet-map) {
                    border-radius: 8px;
                    height: 520px;
                    min-height: 420px;
                    overflow: hidden;
                    width: 100%;
                    z-index: 1;
                }

                :global(.cea-map-pin) {
                    background: transparent;
                    border: 0;
                }

                :global(.cea-map-pin span) {
                    background: var(--pin-color);
                    border: 3px solid #fff;
                    border-radius: 50% 50% 50% 0;
                    box-shadow: 0 8px 18px rgba(42, 7, 16, 0.28);
                    display: block;
                    height: 26px;
                    position: relative;
                    transform: rotate(-45deg);
                    width: 26px;
                }

                :global(.cea-map-pin span::after) {
                    background: #fff;
                    border-radius: 50%;
                    content: "";
                    height: 8px;
                    left: 6px;
                    position: absolute;
                    top: 6px;
                    width: 8px;
                }

                :global(.leaflet-popup-content strong) {
                    color: #b91c31;
                    display: block;
                    font-size: 16px;
                    margin-bottom: 4px;
                }

                .cea-menu-card__body ul,
                .cea-landing-footer ul {
                    display: grid;
                    gap: 8px;
                    list-style: none;
                    margin: 18px 0 0;
                    padding: 0;
                }

                .cea-landing-footer {
                    background: #26070e;
                    color: #fff;
                    padding: 54px 0 24px;
                }

                .cea-footer-grid {
                    display: grid;
                    gap: 30px;
                    grid-template-columns: 1.2fr 0.55fr 0.65fr 0.8fr;
                }

                .cea-footer-brand img {
                    background: #fff;
                    border-radius: 8px;
                    display: block;
                    margin-bottom: 18px;
                    max-width: 230px;
                    padding: 12px;
                }

                .cea-landing-footer h3 {
                    color: #fff;
                    font-size: 18px;
                    font-weight: 900;
                    margin-bottom: 18px;
                }

                .cea-landing-footer a {
                    color: rgba(255, 255, 255, 0.78);
                    font-weight: 800;
                }

                .cea-footer-bottom {
                    border-top: 1px solid rgba(255, 255, 255, 0.16);
                    color: rgba(255, 255, 255, 0.68);
                    margin-top: 36px;
                    padding-top: 20px;
                }

                @media (max-width: 991px) {
                    .cea-landing-hero__grid,
                    .cea-map-layout,
                    .cea-governance-grid,
                    .cea-footer-grid {
                        grid-template-columns: 1fr;
                    }

                    .cea-focus-grid,
                    .cea-menu-grid,
                    .cea-stats__grid {
                        grid-template-columns: 1fr;
                    }

                    .cea-landing-hero__visual {
                        min-height: 240px;
                    }
                }

                @media (max-width: 575px) {
                    .cea-landing-hero {
                        padding: 58px 0 66px;
                    }

                    .cea-landing-hero h1 {
                        font-size: 52px;
                    }

                    .cea-map-shell {
                        padding: 16px;
                    }

                    :global(.cea-leaflet-map) {
                        height: 420px;
                    }
                }
            `}</style>
        </Layout>
    )
}
