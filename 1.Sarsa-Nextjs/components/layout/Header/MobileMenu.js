import Link from "next/link"
import { useState } from "react"
import { ceaNavigation, getPublicHref } from "@/util/ceaNavigation"

const MobileMenu = ({ handleMobileMenuClose, openClass }) => {
    const [isActive, setIsActive] = useState({
        status: false,
        key: "",
    })

    const handleToggle = (key) => {
        if (isActive.key === key) {
            setIsActive({
                status: false,
                key: "",
            })
        } else {
            setIsActive({
                status: true,
                key,
            })
        }
    }

    return (
        <>
            <div className="tgmobile__menu">
                <nav className="tgmobile__menu-box">
                    <div className="close-btn" onClick={handleMobileMenuClose}><i className="fas fa-times" /></div>
                    <div className="nav-logo">
                        <Link href="/" className="cea-logo-image-link" onClick={handleMobileMenuClose}>
                            <img src="/assets/img/cea/1.png" alt="Pooling Fund - KSO" />
                        </Link>
                    </div>
                    <div className="tgmobile__search">
                        <form action="#">
                            <input type="text" placeholder="Cari konten Pooling Fund - KSO..." />
                            <button><i className="far fa-search" /></button>
                        </form>
                    </div>
                    <div className="tgmobile__menu-outer">
                        <ul className="navigation">
                            {ceaNavigation.map((item) => {
                                if (!item.children) {
                                    return (
                                        <li key={item.key}>
                                            <Link href={getPublicHref(item)} onClick={handleMobileMenuClose}>{item.label}</Link>
                                        </li>
                                    )
                                }

                                return (
                                    <li className="menu-item-has-children" key={item.key}>
                                        <a
                                            href="#"
                                            onClick={(event) => {
                                                event.preventDefault()
                                                handleToggle(item.key)
                                            }}
                                        >
                                            {item.label}
                                        </a>
                                        <ul className="sub-menu" style={isActive.key == item.key ? { display: 'block' } : { display: 'none' }}>
                                            {item.children.map((child) => (
                                                <li key={child.key}>
                                                    <Link href={getPublicHref(child)} onClick={handleMobileMenuClose}>{child.label}</Link>
                                                </li>
                                            ))}
                                        </ul>
                                        <div
                                            role="button"
                                            tabIndex={0}
                                            aria-expanded={isActive.key == item.key}
                                            aria-label={`Buka submenu ${item.label}`}
                                            className={`dropdown-btn ${isActive.key == item.key ? "open" : ""}`}
                                            onClick={() => handleToggle(item.key)}
                                            onKeyDown={(event) => {
                                                if (event.key === "Enter" || event.key === " ") {
                                                    event.preventDefault()
                                                    handleToggle(item.key)
                                                }
                                            }}
                                        >
                                            <span className="plus-line" />
                                        </div>
                                    </li>
                                )
                            })}
                        </ul>
                    </div>
                    <div className="social-links">
                        <ul className="list-wrap">
                            <li><Link href="#"><i className="fab fa-facebook-f" /></Link></li>
                            <li><Link href="#"><i className="fab fa-twitter" /></Link></li>
                            <li><Link href="#"><i className="fab fa-instagram" /></Link></li>
                            <li><Link href="#"><i className="fab fa-linkedin-in" /></Link></li>
                            <li><Link href="#"><i className="fab fa-youtube" /></Link></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div className="tgmobile__menu-backdrop" onClick={handleMobileMenuClose} />
        </>
    )
}

export default MobileMenu
