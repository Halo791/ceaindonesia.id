import Layout from "@/components/layout/Layout"
import Link from "next/link"
import { useEffect } from "react"

const historySections = [
    {
        label: "Latar",
        title: "Ruang sipil dan demokrasi sedang menghadapi tekanan berlapis.",
        body: "Demokrasi Indonesia tengah menghadapi tantangan serius. Ruang sipil menyempit, indeks demokrasi menurun, dan oligarki makin menguat dalam menguasai sumber daya alam yang menjadi hajat hidup masyarakat. Pada level global, dunia juga menghadapi krisis multidimensi: pergeseran geoekonomi, ketegangan geopolitik, dampak perubahan iklim, dan ketimpangan kekayaan yang makin jomplang.",
    },
    {
        label: "Februari 2025",
        title: "Proses Pembentukan Pooling Fund - KSO",
        body: "Pada Februari 2025, 48 organisasi masyarakat sipil (OMS) bertemu di Sentul, Bogor, Jawa Barat dan mendiskusikan kondisi ruang-ruang sipil di Indonesia yang menyempit. Pertemuan itu mengidentifikasi kebutuhan bersama akan platform koordinasi dan konsolidasi gerakan OMS di Indonesia, yang kemudian mengarah ke pembentukan Indonesian Civic Engagement Alliance (Pooling Fund - KSO).",
    },
    {
        label: "6-9 Juli 2025",
        title: "Rembug Nasional Pooling Fund - KSO",
        body: "Mandat pembentukan Pooling Fund - KSO di Sentul ditindaklanjuti pada pertemuan rembug nasional OMS di Lembang, Jawa Barat, 6-9 Juli 2025. Sebanyak 61 organisasi dari 19 provinsi hadir, merepresentasi sektor pembangunan dan kemanusiaan. Rembug itu menjadi tonggak penting lahirnya Pooling Fund - KSO sebagai aliansi nasional masyarakat sipil.",
    },
]

const facts = [
    { value: "48", label: "OMS bertemu di Sentul" },
    { value: "61", label: "Organisasi hadir di Lembang" },
    { value: "19", label: "Provinsi terwakili" },
]

const scrambleOverrides = [false, "uppercase", "_"]

function useRiwayatScramble() {
    useEffect(() => {
        let isMounted = true
        let animeTools
        let frameId
        let lastScrollY = window.scrollY
        const activeAnimations = new Map()

        async function play(element, force = false) {
            if (!element || window.matchMedia("(prefers-reduced-motion: reduce)").matches) return

            const now = performance.now()
            const lastRun = Number(element.dataset.lastScramble || 0)
            if (!force && now - lastRun < 900) return

            animeTools = animeTools || await import("animejs")
            if (!isMounted) return

            const { animate, scrambleText } = animeTools
            const overrideIndex = Number(element.dataset.scrambleOverride || 0)

            activeAnimations.get(element)?.cancel?.()
            element.dataset.lastScramble = String(now)
            activeAnimations.set(
                element,
                animate(element, {
                    innerHTML: scrambleText({
                        override: scrambleOverrides[overrideIndex],
                        revealRate: 58,
                        settleRate: 26,
                        duration: 1250,
                    }),
                    duration: 1450,
                    ease: "outQuad",
                })
            )
        }

        const titles = Array.from(document.querySelectorAll(".riwayat-scramble"))
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) play(entry.target, true)
                })
            },
            { threshold: 0.55 }
        )

        titles.forEach((title) => observer.observe(title))

        const handleScroll = () => {
            if (frameId) return

            frameId = window.requestAnimationFrame(() => {
                frameId = null
                const currentScrollY = window.scrollY
                const distance = Math.abs(currentScrollY - lastScrollY)

                if (distance > 14) {
                    titles.forEach((title) => {
                        const rect = title.getBoundingClientRect()
                        const visible = rect.top < window.innerHeight * 0.9 && rect.bottom > window.innerHeight * 0.1
                        if (visible) play(title)
                    })
                }

                lastScrollY = currentScrollY
            })
        }

        window.addEventListener("scroll", handleScroll, { passive: true })

        return () => {
            isMounted = false
            observer.disconnect()
            window.removeEventListener("scroll", handleScroll)
            if (frameId) window.cancelAnimationFrame(frameId)
            activeAnimations.forEach((animation) => animation?.cancel?.())
        }
    }, [])
}

export default function RiwayatPage() {
    useRiwayatScramble()

    return (
        <Layout headerStyle={1} footerStyle={4} headTitle="Riwayat Pooling Fund - KSO">
            <section className="riwayat-hero">
                <div className="container">
                    <div className="riwayat-hero__grid">
                        <div className="riwayat-hero__content">
                            <span>Profil Pooling Fund - KSO</span>
                            <h1 className="riwayat-scramble" data-scramble-override="2">
                                Riwayat
                            </h1>
                            <h2 className="riwayat-scramble" data-scramble-override="1">
                                Proses Pembentukan
                            </h2>
                            <p>
                                Pooling Fund - KSO lahir dari kebutuhan bersama organisasi masyarakat sipil untuk memperkuat
                                koordinasi, konsolidasi, dan kerja kolektif di tengah penyempitan ruang sipil.
                            </p>
                            <div className="riwayat-actions">
                                <Link href="/" className="riwayat-btn">
                                    Kembali ke Beranda
                                </Link>
                                <Link href="/admin/profil/riwayat" className="riwayat-btn secondary">
                                    Kelola di Admin
                                </Link>
                            </div>
                        </div>
                        <div className="riwayat-hero__visual">
                            <img src="/assets/img/cea/campur.png" alt="Pooling Fund - KSO" />
                        </div>
                    </div>
                </div>
            </section>

            <section className="riwayat-facts">
                <div className="container">
                    <div className="riwayat-facts__grid">
                        {facts.map((item) => (
                            <div className="riwayat-fact" key={item.label}>
                                <strong>{item.value}</strong>
                                <span>{item.label}</span>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            <section className="riwayat-body">
                <div className="container">
                    <div className="riwayat-body__head">
                        <span>Linimasa</span>
                        <h2>Dari pertemuan Sentul menuju rembug nasional di Lembang.</h2>
                    </div>

                    <div className="riwayat-timeline">
                        {historySections.map((item) => (
                            <article className="riwayat-timeline__item" key={item.label}>
                                <span>{item.label}</span>
                                <div>
                                    <h3>{item.title}</h3>
                                    <p>{item.body}</p>
                                </div>
                            </article>
                        ))}
                    </div>
                </div>
            </section>

            <footer className="riwayat-footer">
                <div className="container">
                    <img src="/assets/img/cea/1.png" alt="Pooling Fund - KSO" />
                    <p>Merawat ruang sipil, memperkuat gerakan akar rumput.</p>
                </div>
            </footer>

            <style jsx>{`
                .riwayat-hero {
                    background:
                        radial-gradient(circle at 82% 12%, rgba(242, 182, 109, 0.26), transparent 30%),
                        linear-gradient(135deg, #2a0710 0%, #5b0f1a 58%, #7a1626 100%);
                    color: #fff;
                    padding: 82px 0 88px;
                }

                .riwayat-hero__grid {
                    align-items: center;
                    display: grid;
                    gap: 46px;
                    grid-template-columns: minmax(0, 0.86fr) minmax(380px, 1fr);
                }

                .riwayat-hero__content > span,
                .riwayat-body__head > span {
                    color: #f2b66d;
                    display: block;
                    font-size: 13px;
                    font-weight: 900;
                    margin-bottom: 16px;
                    text-transform: uppercase;
                }

                .riwayat-hero h1,
                .riwayat-hero h2 {
                    color: #fff;
                    font-family: var(--tg-heading-font-family);
                    font-weight: 900;
                    letter-spacing: 0;
                    line-height: 0.94;
                    margin: 0;
                    overflow-wrap: anywhere;
                }

                .riwayat-hero h1 {
                    font-size: clamp(62px, 9vw, 126px);
                    margin-bottom: 10px;
                }

                .riwayat-hero h2 {
                    font-size: clamp(42px, 6.5vw, 88px);
                    margin-bottom: 24px;
                }

                .riwayat-hero p {
                    color: rgba(255, 255, 255, 0.84);
                    font-size: 18px;
                    line-height: 1.75;
                    margin-bottom: 30px;
                    max-width: 720px;
                }

                .riwayat-actions {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 12px;
                }

                .riwayat-btn {
                    align-items: center;
                    background: #f2b66d;
                    border: 1px solid #f2b66d;
                    border-radius: 8px;
                    color: #2a0710;
                    display: inline-flex;
                    font-size: 14px;
                    font-weight: 900;
                    min-height: 46px;
                    padding: 12px 18px;
                }

                .riwayat-btn.secondary {
                    background: transparent;
                    border-color: rgba(255, 255, 255, 0.36);
                    color: #fff;
                }

                .riwayat-btn:hover {
                    background: #fff;
                    border-color: #fff;
                    color: #4b0b17;
                }

                .riwayat-hero__visual {
                    background: #fff8f5;
                    border-radius: 8px;
                    box-shadow: 0 34px 80px rgba(42, 7, 16, 0.36);
                    overflow: hidden;
                    padding: 26px;
                }

                .riwayat-hero__visual img {
                    display: block;
                    width: 100%;
                }

                .riwayat-facts {
                    background: #4b0b17;
                    padding: 38px 0;
                }

                .riwayat-facts__grid {
                    display: grid;
                    gap: 18px;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }

                .riwayat-fact {
                    border: 1px solid rgba(255, 255, 255, 0.16);
                    border-radius: 8px;
                    color: #fff;
                    padding: 22px;
                }

                .riwayat-fact strong {
                    color: #f2b66d;
                    display: block;
                    font-size: 48px;
                    font-weight: 900;
                    line-height: 1;
                    margin-bottom: 8px;
                }

                .riwayat-fact span {
                    color: rgba(255, 255, 255, 0.8);
                    font-size: 14px;
                    font-weight: 800;
                }

                .riwayat-body {
                    background: #fff4f2;
                    padding: 78px 0;
                }

                .riwayat-body__head {
                    margin-bottom: 32px;
                    max-width: 820px;
                }

                .riwayat-body__head > span {
                    color: #b91c31;
                    margin-bottom: 8px;
                }

                .riwayat-body__head h2 {
                    color: #3a0710;
                    font-size: clamp(30px, 3.8vw, 52px);
                    font-weight: 900;
                    line-height: 1.1;
                    margin: 0;
                }

                .riwayat-timeline {
                    display: grid;
                    gap: 18px;
                }

                .riwayat-timeline__item {
                    background: #fff;
                    border: 1px solid #efd0d0;
                    border-radius: 8px;
                    box-shadow: 0 18px 44px rgba(75, 11, 23, 0.08);
                    display: grid;
                    gap: 24px;
                    grid-template-columns: 170px minmax(0, 1fr);
                    padding: 26px;
                }

                .riwayat-timeline__item > span {
                    color: #b91c31;
                    font-size: 13px;
                    font-weight: 900;
                    text-transform: uppercase;
                }

                .riwayat-timeline__item h3 {
                    color: #3a0710;
                    font-size: 25px;
                    font-weight: 900;
                    line-height: 1.18;
                    margin-bottom: 12px;
                }

                .riwayat-timeline__item p {
                    color: #67464b;
                    font-size: 16px;
                    line-height: 1.82;
                    margin: 0;
                }

                .riwayat-footer {
                    background: #26070e;
                    color: #fff;
                    padding: 34px 0;
                }

                .riwayat-footer img {
                    background: #fff;
                    border-radius: 8px;
                    display: block;
                    margin-bottom: 14px;
                    max-width: 210px;
                    padding: 12px;
                }

                .riwayat-footer p {
                    color: rgba(255, 255, 255, 0.78);
                    margin: 0;
                }

                @media (max-width: 991px) {
                    .riwayat-hero__grid,
                    .riwayat-timeline__item {
                        grid-template-columns: 1fr;
                    }

                    .riwayat-facts__grid {
                        grid-template-columns: 1fr;
                    }
                }

                @media (max-width: 575px) {
                    .riwayat-hero {
                        padding: 60px 0 68px;
                    }

                    .riwayat-hero h1 {
                        font-size: 64px;
                    }

                    .riwayat-hero h2 {
                        font-size: 42px;
                    }
                }
            `}</style>
        </Layout>
    )
}
