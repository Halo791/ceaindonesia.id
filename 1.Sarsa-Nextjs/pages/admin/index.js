import CeaAdminShell from "@/components/admin/CeaAdminShell"
import { ceaNavigation, dropdownSections, getAdminChildItems } from "@/util/ceaNavigation"
import Link from "next/link"

export default function AdminDashboard() {
    const childItems = getAdminChildItems()

    return (
        <CeaAdminShell
            title="Dashboard Konten CEA"
            description="Panel ini mengadopsi struktur menu dan dropdown dari ceaindonesia.id, lalu menyiapkan ruang kelola untuk setiap kanal dropdown."
            sourceHref="https://ceaindonesia.id/"
            headTitle="Panel Admin CEA"
        >
            <div className="admin-stat-strip">
                <div className="admin-stat">
                    <span>Menu utama</span>
                    <strong>{ceaNavigation.length}</strong>
                </div>
                <div className="admin-stat">
                    <span>Dropdown</span>
                    <strong>{dropdownSections.length}</strong>
                </div>
                <div className="admin-stat">
                    <span>Kanal admin</span>
                    <strong>{childItems.length}</strong>
                </div>
                <div className="admin-stat">
                    <span>Status</span>
                    <strong>Draft</strong>
                </div>
            </div>

            <div className="admin-grid">
                {dropdownSections.map((section) => (
                    <article className="admin-card" key={section.key}>
                        <span className="admin-card__label">{section.children.length} dropdown</span>
                        <h2>{section.label}</h2>
                        <p>{section.description}</p>
                        <div className="admin-card__actions">
                            <Link className="admin-button" href={`/admin/${section.key}`}>
                                Kelola {section.label}
                            </Link>
                            <a className="admin-button secondary" href={section.sourceHref} target="_blank" rel="noreferrer">
                                Lihat sumber
                            </a>
                        </div>
                    </article>
                ))}
            </div>

            <div className="admin-table-card admin-section-spacer">
                <div className="admin-table-card__head">
                    <div>
                        <h2>Semua Halaman Dropdown</h2>
                        <p>Daftar halaman admin yang disiapkan untuk setiap item dropdown menu.</p>
                    </div>
                    <Link className="admin-button secondary" href="/admin/siar">
                        Buka Siar
                    </Link>
                </div>
                <div className="admin-table-wrap">
                    <table className="admin-table">
                        <thead>
                            <tr>
                                <th>Section</th>
                                <th>Halaman</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {childItems.map((item) => (
                                <tr key={`${item.sectionKey}-${item.key}`}>
                                    <td>{item.sectionLabel}</td>
                                    <td><strong>{item.label}</strong></td>
                                    <td>{item.description}</td>
                                    <td><span className="admin-status">Siap diedit</span></td>
                                    <td>
                                        <Link href={item.href}>Kelola</Link>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </CeaAdminShell>
    )
}
