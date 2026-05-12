import dynamic from 'next/dynamic'
import Link from "next/link"
import { useRouter } from "next/router"
import { useEffect, useState } from "react"
import { ceaNavigation, getPublicHref } from "@/util/ceaNavigation"
const ThemeSwitch = dynamic(() => import('@/components/elements/ThemeSwitch'), {
    ssr: false
})

export default function Menu({ handleMobileMenuOpen, handleSidebarOpen, offCanvasNav, logoAlt, white }) {
    const router = useRouter()
    const [searchToggle, setSearchToggle] = useState(false)
    const [openDropdown, setOpenDropdown] = useState("")
    const searchHandle = () => setSearchToggle(!searchToggle)
    const isActive = (item) => {
        const href = getPublicHref(item)

        if (href === "/") return router.pathname === "/"

        return router.asPath === href || router.asPath.startsWith(`${href}/`)
    }
    const closeDropdown = () => setOpenDropdown("")

    useEffect(() => {
        closeDropdown()
    }, [router.asPath])

    return (
        <>
            <div className="tgmenu__wrap">
                <nav className="tgmenu__nav">
                    <div className="logo d-block d-lg-none">
                        <Link href="/" className="cea-logo-image-link cea-logo-image-link--mobile">
                            <img src="/assets/img/cea/1.png" alt="Pooling Fund - KSO" />
                        </Link>
                    </div>
                    {logoAlt &&
                        <div className="d-flex gap-4 align-items-center">
                            <div className="offcanvas-toggle" onClick={handleSidebarOpen}>
                                <Link href="#"><i className="flaticon-menu-bar" /></Link>
                            </div>
                            <div className="logo">
                                <Link href="/" className="cea-logo-image-link">
                                    <img src="/assets/img/cea/1.png" alt="Pooling Fund - KSO" />
                                </Link>
                            </div>
                        </div>
                    }
                    {offCanvasNav &&
                        <div className="offcanvas-toggle" onClick={handleSidebarOpen}>
                            <a href="#"><i className="flaticon-menu-bar" /></a>
                        </div>
                    }
                    <div className="tgmenu__navbar-wrap tgmenu__main-menu d-none d-lg-flex">
                        <ul className="navigation">
                            {ceaNavigation.map((item) => (
                                <li
                                    key={item.key}
                                    className={`${item.children ? "menu-item-has-children" : ""} ${openDropdown === item.key ? "is-open" : ""} ${isActive(item) ? "active" : ""}`}
                                    onMouseEnter={() => item.children && setOpenDropdown(item.key)}
                                    onMouseLeave={() => item.children && closeDropdown()}
                                >
                                    <Link
                                        href={getPublicHref(item)}
                                        aria-expanded={item.children ? openDropdown === item.key : undefined}
                                        aria-haspopup={item.children ? "true" : undefined}
                                        onClick={(event) => {
                                            if (!item.children) return
                                            event.preventDefault()
                                            setOpenDropdown((current) => current === item.key ? "" : item.key)
                                        }}
                                        onFocus={() => item.children && setOpenDropdown(item.key)}
                                    >
                                        {item.label}
                                    </Link>
                                    {item.children &&
                                        <ul className="sub-menu">
                                            {item.children.map((child) => (
                                                <li key={child.key} className={isActive(child) ? "active" : ""}>
                                                    <Link href={getPublicHref(child)} onClick={closeDropdown}>{child.label}</Link>
                                                </li>
                                            ))}
                                        </ul>
                                    }
                                </li>
                            ))}
                        </ul>
                    </div>
                    <div className="tgmenu__action">
                        <ul className="list-wrap">
                            <li className="mode-switcher">
                                <ThemeSwitch />
                            </li>
                            <li className="user"><Link href="/admin" title="Panel Admin Pooling Fund - KSO"><i className="far fa-user" /></Link></li>
                            <li className="header-search"><Link href="#"><i className={`${searchToggle ? "far fa-search fa-times" : "far fa-search"} `} onClick={searchHandle} /></Link>
                                <div className="header__style-two">
                                    <div className={`header__top-search ${searchToggle ? "d-block" : "d-none"}`}>
                                        <form action="#">
                                            <input type="text" placeholder="Cari konten Pooling Fund - KSO..." />
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <div className="mobile-nav-toggler" onClick={handleMobileMenuOpen}><i className="fas fa-bars" /></div>
            </div>
        </>
    )
}
