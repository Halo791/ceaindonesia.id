import Link from "next/link"

export default function Sidebar({ handleSidebarClose }) {
    return (
        <>
            <div className="offCanvas__wrap">
                <div className="offCanvas__body">
                    <div className="offCanvas__toggle" onClick={handleSidebarClose}><i className="flaticon-addition" /></div>
                    <div className="offCanvas__content">
                        <div className="offCanvas__logo logo">
                            <Link href="/" className="cea-logo-image-link">
                                <img src="/assets/img/cea/1.png" alt="Pooling Fund - KSO" />
                            </Link>
                        </div>
                        <p>Pooling Fund - KSO adalah aliansi organisasi masyarakat sipil yang bekerja bersama untuk demokrasi, ruang sipil, keadilan sosial, dan kelestarian alam.</p>
                    </div>
                    <div className="offCanvas__contact">
                        <h4 className="title">Kontak Pooling Fund - KSO</h4>
                        <ul className="offCanvas__contact-list list-wrap">
                            <li><i className="fas fa-envelope-open" /><Link href="mailto:sekretariat@ksopoolingfund.id">sekretariat@ksopoolingfund.id</Link></li>
                            <li><i className="fas fa-map-marker-alt" /> DI Yogyakarta, Indonesia</li>
                        </ul>
                        <ul className="offCanvas__social list-wrap">
                            <li><Link href="#"><i className="fab fa-facebook-f" /></Link></li>
                            <li><Link href="#"><i className="fab fa-twitter" /></Link></li>
                            <li><Link href="#"><i className="fab fa-linkedin-in" /></Link></li>
                            <li><Link href="#"><i className="fab fa-youtube" /></Link></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div className="offCanvas__overlay" onClick={handleSidebarClose} />
        </>
    )
}
