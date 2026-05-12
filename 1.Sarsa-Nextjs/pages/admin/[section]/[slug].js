import CeaAdminShell from "@/components/admin/CeaAdminShell"
import { getAdminChildItems, getAdminItem } from "@/util/ceaNavigation"
import Link from "next/link"

export default function AdminDropdownItemPage({ item }) {
    const section = item.section

    return (
        <CeaAdminShell
            activeSection={section.key}
            activeItem={item.key}
            title={`Kelola ${item.label}`}
            description={item.description}
            sourceHref={item.sourceHref}
            headTitle={`Admin ${item.label}`}
        >
            <div className="admin-stat-strip">
                <div className="admin-stat">
                    <span>Parent menu</span>
                    <strong>{section.label}</strong>
                </div>
                <div className="admin-stat">
                    <span>Slug</span>
                    <strong>{item.key}</strong>
                </div>
                <div className="admin-stat">
                    <span>Template</span>
                    <strong>Konten</strong>
                </div>
                <div className="admin-stat">
                    <span>Status</span>
                    <strong>Draft</strong>
                </div>
            </div>

            <div className="admin-form-card">
                <h2>Konten Halaman</h2>
                <p>Form dasar untuk mengelola judul, slug, ringkasan, sumber, status publikasi, dan prioritas tampilan.</p>
                <div className="admin-form-grid">
                    <div className="admin-field">
                        <label>Judul halaman</label>
                        <input defaultValue={item.label} />
                    </div>
                    <div className="admin-field">
                        <label>Parent dropdown</label>
                        <input defaultValue={section.label} />
                    </div>
                    <div className="admin-field">
                        <label>Slug</label>
                        <input defaultValue={item.key} />
                    </div>
                    <div className="admin-field">
                        <label>Status publikasi</label>
                        <select defaultValue="draft">
                            <option value="draft">Draft</option>
                            <option value="review">Review</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    <div className="admin-field full">
                        <label>Ringkasan</label>
                        <textarea defaultValue={item.description} />
                    </div>
                    <div className="admin-field">
                        <label>URL sumber resmi</label>
                        <input defaultValue={item.sourceHref} />
                    </div>
                    <div className="admin-field">
                        <label>Prioritas tampilan</label>
                        <select defaultValue="normal">
                            <option value="tinggi">Tinggi</option>
                            <option value="normal">Normal</option>
                            <option value="rendah">Rendah</option>
                        </select>
                    </div>
                </div>
                <div className="admin-upload-zone">
                    <div>
                        <strong>Media unggulan</strong>
                        <span>Siapkan area unggah gambar, PDF, atau dokumen pendukung.</span>
                    </div>
                    <button className="admin-button secondary" type="button">Pilih file</button>
                </div>
                <div className="admin-form-actions admin-section-spacer">
                    <button className="admin-button" type="button">Simpan draft</button>
                    <button className="admin-button secondary" type="button">Pratinjau</button>
                    <button className="admin-button secondary" type="button">Jadwalkan</button>
                </div>
            </div>

            <div className="admin-grid two admin-section-spacer">
                <section className="admin-form-card">
                    <h2>Checklist Editorial</h2>
                    <div className="admin-form-grid">
                        <div className="admin-field full">
                            <label>Catatan editor</label>
                            <textarea defaultValue="Pastikan narasi sesuai nilai CEA, tautan sumber resmi aktif, dan metadata sudah lengkap." />
                        </div>
                        <div className="admin-field">
                            <label>Penanggung jawab</label>
                            <input defaultValue="Sekretariat CEA" />
                        </div>
                        <div className="admin-field">
                            <label>Tanggal target</label>
                            <input type="date" defaultValue="2026-05-10" />
                        </div>
                    </div>
                </section>

                <section className="admin-form-card">
                    <h2>SEO & Navigasi</h2>
                    <div className="admin-form-grid">
                        <div className="admin-field full">
                            <label>Meta title</label>
                            <input defaultValue={`${item.label} | CEA Indonesia`} />
                        </div>
                        <div className="admin-field full">
                            <label>Meta description</label>
                            <textarea defaultValue={item.description} />
                        </div>
                    </div>
                </section>
            </div>

            <div className="admin-table-card admin-section-spacer">
                <div className="admin-table-card__head">
                    <div>
                        <h2>Riwayat Revisi</h2>
                        <p>Contoh alur revisi untuk panel konten setiap dropdown.</p>
                    </div>
                    <Link className="admin-button secondary" href={`/admin/${section.key}`}>
                        Kembali ke {section.label}
                    </Link>
                </div>
                <div className="admin-table-wrap">
                    <table className="admin-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Editor</th>
                                <th>Perubahan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>10 Mei 2026</td>
                                <td>Admin CEA</td>
                                <td>Halaman admin dibuat dari struktur dropdown ceaindonesia.id.</td>
                                <td><span className="admin-status">Draft awal</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </CeaAdminShell>
    )
}

export async function getStaticPaths() {
    return {
        paths: getAdminChildItems().map((item) => ({
            params: {
                section: item.sectionKey,
                slug: item.key,
            },
        })),
        fallback: false,
    }
}

export async function getStaticProps({ params }) {
    const item = getAdminItem(params.section, params.slug)

    if (!item) {
        return { notFound: true }
    }

    return {
        props: {
            item,
        },
    }
}
