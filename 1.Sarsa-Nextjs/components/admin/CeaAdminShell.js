import Layout from "@/components/layout/Layout"
import { ceaNavigation, getAdminChildItems } from "@/util/ceaNavigation"
import Link from "next/link"

export default function CeaAdminShell({
    activeSection,
    activeItem,
    children,
    description,
    eyebrow = "Panel Admin Pooling Fund - KSO",
    headTitle,
    sourceHref,
    title,
}) {
    const childItems = getAdminChildItems()

    return (
        <Layout headerStyle={1} footerStyle={4} headTitle={headTitle || title}>
            <section className="cea-admin-panel">
                <div className="admin-shell">
                    <aside className="admin-sidebar">
                        <div className="admin-sidebar__brand">
                            <span>Pooling Fund - KSO CMS</span>
                            <strong>{childItems.length} kanal dropdown</strong>
                        </div>
                        <nav className="admin-sidebar__nav" aria-label="Navigasi panel admin">
                            <Link href="/admin" className={!activeSection ? "active" : ""}>
                                Dashboard
                            </Link>
                            {ceaNavigation.map((section) => (
                                <div className="admin-sidebar__group" key={section.key}>
                                    <Link
                                        href={`/admin/${section.key}`}
                                        className={activeSection === section.key && !activeItem ? "active" : ""}
                                    >
                                        {section.label}
                                    </Link>
                                    {section.children &&
                                        <div className="admin-sidebar__children">
                                            {section.children.map((item) => (
                                                <Link
                                                    href={item.href}
                                                    key={item.key}
                                                    className={activeSection === section.key && activeItem === item.key ? "active" : ""}
                                                >
                                                    {item.label}
                                                </Link>
                                            ))}
                                        </div>
                                    }
                                </div>
                            ))}
                        </nav>
                    </aside>

                    <div className="admin-workspace">
                        <header className="admin-hero">
                            <div>
                                <span className="admin-eyebrow">{eyebrow}</span>
                                <h1>{title}</h1>
                                {description && <p>{description}</p>}
                            </div>
                            {sourceHref &&
                                <a className="admin-source-link" href={sourceHref} target="_blank" rel="noreferrer">
                                    Sumber resmi
                                </a>
                            }
                        </header>
                        {children}
                    </div>
                </div>
            </section>

            <style jsx global>{`
                .cea-admin-panel {
                    background: #f4f7f4;
                    min-height: 100vh;
                    padding: 34px 0 54px;
                }

                .admin-shell {
                    display: grid;
                    grid-template-columns: 280px minmax(0, 1fr);
                    gap: 24px;
                    margin: 0 auto;
                    max-width: 1320px;
                    padding: 0 20px;
                }

                .admin-sidebar {
                    align-self: start;
                    background: #102f22;
                    border: 1px solid rgba(255, 255, 255, 0.08);
                    border-radius: 8px;
                    color: #fff;
                    overflow: hidden;
                    position: sticky;
                    top: 92px;
                }

                .admin-sidebar__brand {
                    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                    padding: 20px;
                }

                .admin-sidebar__brand span,
                .admin-eyebrow {
                    display: block;
                    font-size: 12px;
                    font-weight: 700;
                    letter-spacing: 0;
                    text-transform: uppercase;
                }

                .admin-sidebar__brand strong {
                    display: block;
                    font-size: 14px;
                    font-weight: 600;
                    margin-top: 6px;
                    opacity: 0.72;
                }

                .admin-sidebar__nav {
                    display: flex;
                    flex-direction: column;
                    padding: 12px;
                }

                .admin-sidebar__nav a {
                    border-radius: 8px;
                    color: rgba(255, 255, 255, 0.78);
                    display: block;
                    font-size: 13px;
                    font-weight: 700;
                    line-height: 1.25;
                    padding: 10px 12px;
                    text-transform: uppercase;
                }

                .admin-sidebar__nav a:hover,
                .admin-sidebar__nav a.active {
                    background: #f3aa3d;
                    color: #102f22;
                }

                .admin-sidebar__children {
                    border-left: 1px solid rgba(255, 255, 255, 0.12);
                    display: grid;
                    gap: 2px;
                    margin: 2px 0 8px 12px;
                    padding-left: 8px;
                }

                .admin-sidebar__children a {
                    font-size: 12px;
                    font-weight: 600;
                    text-transform: none;
                }

                .admin-workspace {
                    min-width: 0;
                }

                .admin-hero,
                .admin-card,
                .admin-table-card,
                .admin-form-card {
                    background: #fff;
                    border: 1px solid #dfe7df;
                    border-radius: 8px;
                    box-shadow: 0 14px 36px rgba(16, 47, 34, 0.06);
                }

                .admin-hero {
                    align-items: flex-start;
                    display: flex;
                    justify-content: space-between;
                    gap: 20px;
                    margin-bottom: 24px;
                    padding: 28px;
                }

                .admin-eyebrow {
                    color: #1b5e3b;
                    margin-bottom: 8px;
                }

                .admin-hero h1 {
                    color: #102f22;
                    font-size: 32px;
                    line-height: 1.12;
                    margin-bottom: 10px;
                }

                .admin-hero p {
                    color: #59675e;
                    font-size: 15px;
                    line-height: 1.7;
                    margin: 0;
                    max-width: 760px;
                }

                .admin-source-link,
                .admin-button {
                    align-items: center;
                    background: #1b5e3b;
                    border: 1px solid #1b5e3b;
                    border-radius: 8px;
                    color: #fff;
                    display: inline-flex;
                    font-size: 13px;
                    font-weight: 700;
                    justify-content: center;
                    min-height: 40px;
                    padding: 10px 14px;
                    text-align: center;
                    white-space: nowrap;
                }

                button.admin-button {
                    cursor: pointer;
                    font-family: inherit;
                }

                .admin-source-link:hover,
                .admin-button:hover {
                    background: #123f29;
                    border-color: #123f29;
                    color: #fff;
                }

                .admin-button.secondary {
                    background: #fff;
                    border-color: #cfdacf;
                    color: #102f22;
                }

                .admin-button.secondary:hover {
                    background: #f4f7f4;
                    color: #102f22;
                }

                .admin-grid {
                    display: grid;
                    gap: 18px;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }

                .admin-grid.two {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .admin-card,
                .admin-form-card {
                    padding: 22px;
                }

                .admin-card__label {
                    color: #8b625a;
                    display: block;
                    font-size: 12px;
                    font-weight: 800;
                    margin-bottom: 8px;
                    text-transform: uppercase;
                }

                .admin-card h2,
                .admin-card h3,
                .admin-form-card h2,
                .admin-table-card h2 {
                    color: #102f22;
                    font-size: 20px;
                    line-height: 1.25;
                    margin-bottom: 10px;
                }

                .admin-card p,
                .admin-form-card p {
                    color: #59675e;
                    font-size: 14px;
                    line-height: 1.65;
                    margin-bottom: 16px;
                }

                .admin-card__actions,
                .admin-form-actions {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 10px;
                }

                .admin-stat-strip {
                    display: grid;
                    gap: 14px;
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                    margin-bottom: 24px;
                }

                .admin-stat {
                    background: #fff;
                    border: 1px solid #dfe7df;
                    border-radius: 8px;
                    padding: 18px;
                }

                .admin-stat span {
                    color: #59675e;
                    display: block;
                    font-size: 12px;
                    font-weight: 700;
                    margin-bottom: 8px;
                    text-transform: uppercase;
                }

                .admin-stat strong {
                    color: #102f22;
                    display: block;
                    font-size: 30px;
                    line-height: 1;
                }

                .admin-table-card {
                    overflow: hidden;
                }

                .admin-table-card__head {
                    align-items: center;
                    border-bottom: 1px solid #dfe7df;
                    display: flex;
                    justify-content: space-between;
                    gap: 16px;
                    padding: 20px 22px;
                }

                .admin-table-card__head p {
                    color: #59675e;
                    font-size: 14px;
                    line-height: 1.6;
                    margin: 0;
                }

                .admin-table-wrap {
                    overflow-x: auto;
                }

                .admin-table {
                    border-collapse: collapse;
                    min-width: 760px;
                    width: 100%;
                }

                .admin-table th,
                .admin-table td {
                    border-bottom: 1px solid #edf1ed;
                    color: #4f5c54;
                    font-size: 14px;
                    padding: 14px 18px;
                    text-align: left;
                    vertical-align: top;
                }

                .admin-table th {
                    color: #102f22;
                    font-size: 12px;
                    font-weight: 800;
                    text-transform: uppercase;
                }

                .admin-table td strong {
                    color: #102f22;
                }

                .admin-status {
                    background: #e9f5ec;
                    border-radius: 999px;
                    color: #1b5e3b;
                    display: inline-flex;
                    font-size: 12px;
                    font-weight: 800;
                    padding: 5px 10px;
                }

                .admin-form-grid {
                    display: grid;
                    gap: 16px;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }

                .admin-field,
                .admin-field.full {
                    display: grid;
                    gap: 8px;
                }

                .admin-field.full {
                    grid-column: 1 / -1;
                }

                .admin-field label {
                    color: #102f22;
                    font-size: 13px;
                    font-weight: 800;
                }

                .admin-field input,
                .admin-field select,
                .admin-field textarea {
                    background: #f8faf8;
                    border: 1px solid #cfdacf;
                    border-radius: 8px;
                    color: #102f22;
                    font-size: 14px;
                    min-height: 44px;
                    padding: 11px 12px;
                    width: 100%;
                }

                .admin-field textarea {
                    min-height: 140px;
                    resize: vertical;
                }

                .admin-upload-zone {
                    align-items: center;
                    background: #f8faf8;
                    border: 1px dashed #adc2b2;
                    border-radius: 8px;
                    color: #59675e;
                    display: flex;
                    justify-content: space-between;
                    gap: 16px;
                    margin-top: 10px;
                    padding: 18px;
                }

                .admin-upload-zone strong {
                    color: #102f22;
                    display: block;
                    margin-bottom: 4px;
                }

                .admin-section-spacer {
                    margin-top: 22px;
                }

                @media (max-width: 1199px) {
                    .admin-shell {
                        grid-template-columns: 1fr;
                    }

                    .admin-sidebar {
                        position: static;
                    }

                    .admin-sidebar__nav {
                        display: grid;
                        grid-template-columns: repeat(2, minmax(0, 1fr));
                    }
                }

                @media (max-width: 767px) {
                    .cea-admin-panel {
                        padding-top: 22px;
                    }

                    .admin-shell {
                        padding: 0 14px;
                    }

                    .admin-sidebar__nav,
                    .admin-grid,
                    .admin-grid.two,
                    .admin-stat-strip,
                    .admin-form-grid {
                        grid-template-columns: 1fr;
                    }

                    .admin-hero {
                        display: block;
                        padding: 22px;
                    }

                    .admin-source-link {
                        margin-top: 16px;
                    }

                    .admin-hero h1 {
                        font-size: 26px;
                    }
                }
            `}</style>
        </Layout>
    )
}
