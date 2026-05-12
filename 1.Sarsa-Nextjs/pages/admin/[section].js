import CeaAdminShell from "@/components/admin/CeaAdminShell"
import { ceaNavigation, getAdminSection } from "@/util/ceaNavigation"
import Link from "next/link"

export default function AdminSectionPage({ section }) {
    const hasChildren = Boolean(section.children?.length)

    return (
        <CeaAdminShell
            activeSection={section.key}
            title={`Kelola ${section.label}`}
            description={section.description}
            sourceHref={section.sourceHref}
            headTitle={`Admin ${section.label}`}
        >
            <div className="admin-stat-strip">
                <div className="admin-stat">
                    <span>Tipe</span>
                    <strong>{hasChildren ? "Dropdown" : "Menu"}</strong>
                </div>
                <div className="admin-stat">
                    <span>Subhalaman</span>
                    <strong>{section.children?.length || 1}</strong>
                </div>
                <div className="admin-stat">
                    <span>Bahasa</span>
                    <strong>ID</strong>
                </div>
                <div className="admin-stat">
                    <span>Status</span>
                    <strong>Aktif</strong>
                </div>
            </div>

            {hasChildren ? (
                <>
                    <div className="admin-grid two">
                        {section.children.map((item) => (
                            <article className="admin-card" key={item.key}>
                                <span className="admin-card__label">{section.label}</span>
                                <h2>{item.label}</h2>
                                <p>{item.description}</p>
                                <div className="admin-card__actions">
                                    <Link className="admin-button" href={item.href}>
                                        Kelola halaman
                                    </Link>
                                    <a className="admin-button secondary" href={item.sourceHref} target="_blank" rel="noreferrer">
                                        Sumber
                                    </a>
                                </div>
                            </article>
                        ))}
                    </div>

                    <div className="admin-table-card admin-section-spacer">
                        <div className="admin-table-card__head">
                            <div>
                                <h2>Urutan Dropdown {section.label}</h2>
                                <p>Gunakan daftar ini sebagai rancangan urutan menu yang tampil di header.</p>
                            </div>
                            <Link className="admin-button secondary" href="/admin">
                                Dashboard
                            </Link>
                        </div>
                        <div className="admin-table-wrap">
                            <table className="admin-table">
                                <thead>
                                    <tr>
                                        <th>Urutan</th>
                                        <th>Nama menu</th>
                                        <th>Slug admin</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {section.children.map((item, index) => (
                                        <tr key={item.key}>
                                            <td>{index + 1}</td>
                                            <td><strong>{item.label}</strong></td>
                                            <td>{item.key}</td>
                                            <td><span className="admin-status">Terpasang</span></td>
                                            <td><Link href={item.href}>Edit</Link></td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </>
            ) : (
                <div className="admin-form-card">
                    <h2>Form Kelola Menu {section.label}</h2>
                    <p>Halaman ini disiapkan untuk konten menu utama yang tidak memiliki dropdown.</p>
                    <div className="admin-form-grid">
                        <div className="admin-field">
                            <label>Judul menu</label>
                            <input defaultValue={section.label} />
                        </div>
                        <div className="admin-field">
                            <label>Slug</label>
                            <input defaultValue={section.key} />
                        </div>
                        <div className="admin-field full">
                            <label>Deskripsi</label>
                            <textarea defaultValue={section.description} />
                        </div>
                        <div className="admin-field">
                            <label>Status publikasi</label>
                            <select defaultValue="aktif">
                                <option value="aktif">Aktif</option>
                                <option value="draft">Draft</option>
                                <option value="arsip">Arsip</option>
                            </select>
                        </div>
                        <div className="admin-field">
                            <label>URL sumber</label>
                            <input defaultValue={section.sourceHref} />
                        </div>
                    </div>
                    <div className="admin-form-actions admin-section-spacer">
                        <button className="admin-button" type="button">Simpan draft</button>
                        <button className="admin-button secondary" type="button">Pratinjau</button>
                    </div>
                </div>
            )}
        </CeaAdminShell>
    )
}

export async function getStaticPaths() {
    return {
        paths: ceaNavigation.map((section) => ({ params: { section: section.key } })),
        fallback: false,
    }
}

export async function getStaticProps({ params }) {
    const section = getAdminSection(params.section)

    if (!section) {
        return { notFound: true }
    }

    return {
        props: {
            section,
        },
    }
}
