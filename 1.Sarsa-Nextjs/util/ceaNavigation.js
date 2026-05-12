const ceaBaseUrl = "https://ceaindonesia.id"

export const ceaNavigation = [
    {
        key: "beranda",
        label: "BERANDA",
        href: "/",
        sourceHref: `${ceaBaseUrl}/`,
        description: "Halaman utama Pooling Fund - KSO dan ringkasan aliansi.",
    },
    {
        key: "profil",
        label: "PROFIL",
        href: "/admin/profil",
        publicHref: "/profil/riwayat",
        sourceHref: `${ceaBaseUrl}/riwayat/`,
        description: "Kelola riwayat, mandat, struktur gerak, sumber daya, kontak, dan dokumen profil Pooling Fund - KSO.",
        children: [
            {
                key: "riwayat",
                label: "Riwayat",
                href: "/admin/profil/riwayat",
                publicHref: "/profil/riwayat",
                sourceHref: `${ceaBaseUrl}/riwayat/`,
                description: "Latar pembentukan Pooling Fund - KSO dan kronologi rembug nasional.",
            },
            {
                key: "mandat-visi-nilai",
                label: "Mandat, Visi, Nilai",
                href: "/admin/profil/mandat-visi-nilai",
                sourceHref: `${ceaBaseUrl}/`,
                description: "Visi, mandat, tujuan, dan nilai-nilai gerakan Pooling Fund - KSO.",
            },
            {
                key: "struktur-gerak",
                label: "Struktur Gerak",
                href: "/admin/profil/struktur-gerak",
                sourceHref: `${ceaBaseUrl}/struktur-gerak-cea/`,
                description: "Struktur jejaring, simpul regional, gugus tugas, dan kaukus isu.",
            },
            {
                key: "sumber-daya",
                label: "Sumber Daya",
                href: "/admin/profil/sumber-daya",
                sourceHref: `${ceaBaseUrl}/tata-kelola-sumber-daya-cea/`,
                description: "Tata kelola sumber daya, mobilisasi, distribusi, dan kontribusi aliansi.",
            },
            {
                key: "kontak",
                label: "Kontak",
                href: "/admin/profil/kontak",
                sourceHref: `${ceaBaseUrl}/kontak/`,
                description: "Alamat sekretariat, kanal kontak, dan informasi penghubung publik.",
            },
            {
                key: "unduh-profil-id",
                label: "Unduh Profil (ID)",
                href: "/admin/profil/unduh-profil-id",
                sourceHref: `${ceaBaseUrl}/unduh/profil-cea-versi-ponsel/`,
                description: "Dokumen profil Pooling Fund - KSO versi bahasa Indonesia.",
            },
            {
                key: "download-profile-en",
                label: "Download Profile (EN)",
                href: "/admin/profil/download-profile-en",
                sourceHref: `${ceaBaseUrl}/`,
                description: "Dokumen profil Pooling Fund - KSO versi bahasa Inggris.",
            },
        ],
    },
    {
        key: "regio",
        label: "REGIO",
        href: "/admin/regio",
        sourceHref: `${ceaBaseUrl}/`,
        description: "Kelola data simpul regional dan organisasi anggota Pooling Fund - KSO.",
        children: [
            {
                key: "simpul",
                label: "Simpul",
                href: "/admin/regio/simpul",
                sourceHref: `${ceaBaseUrl}/`,
                description: "Peta simpul, focal point, wilayah kerja, dan status regional.",
            },
            {
                key: "anggota",
                label: "Anggota",
                href: "/admin/regio/anggota",
                sourceHref: `${ceaBaseUrl}/`,
                description: "Direktori organisasi anggota, profil lembaga, dan relasi simpul.",
            },
        ],
    },
    {
        key: "siar",
        label: "SIAR",
        href: "/admin/siar",
        sourceHref: `${ceaBaseUrl}/siar/`,
        description: "Kelola kanal publikasi Pooling Fund - KSO: kabar, rilis, prakarsa, refleksi, dan referensi.",
        children: [
            {
                key: "kabar",
                label: "Kabar",
                href: "/admin/siar/kabar",
                sourceHref: `${ceaBaseUrl}/siar/`,
                description: "Artikel kabar terbaru dari kegiatan dan jejaring Pooling Fund - KSO.",
            },
            {
                key: "rilis",
                label: "Rilis",
                href: "/admin/siar/rilis",
                sourceHref: `${ceaBaseUrl}/siar/`,
                description: "Rilis pers, pernyataan solidaritas, dan respons kelembagaan.",
            },
            {
                key: "prakarsa",
                label: "Prakarsa",
                href: "/admin/siar/prakarsa",
                sourceHref: `${ceaBaseUrl}/siar/`,
                description: "Inisiatif, program, dan praktik kolaboratif dari simpul Pooling Fund - KSO.",
            },
            {
                key: "refleksi",
                label: "Refleksi",
                href: "/admin/siar/refleksi",
                sourceHref: `${ceaBaseUrl}/siar/refleksi/`,
                description: "Tulisan reflektif tentang ruang sipil, demokrasi, dan gerakan sosial.",
            },
            {
                key: "referensi",
                label: "Referensi",
                href: "/admin/siar/referensi",
                sourceHref: `${ceaBaseUrl}/siar/`,
                description: "Bahan bacaan, dokumen pengetahuan, dan rujukan riset.",
            },
        ],
    },
    {
        key: "aksi",
        label: "AKSI",
        href: "/admin/aksi",
        sourceHref: `${ceaBaseUrl}/rencana-aksi-cea/`,
        description: "Kelola manifesto, kajian, gugus tugas, kaukus isu, dan diskursus publik Pooling Fund - KSO.",
        children: [
            {
                key: "manifesto",
                label: "Manifesto",
                href: "/admin/aksi/manifesto",
                sourceHref: `${ceaBaseUrl}/rencana-aksi-cea/`,
                description: "Narasi dasar, posisi gerakan, dan arah aksi Pooling Fund - KSO.",
            },
            {
                key: "kajian-strategis",
                label: "Kajian Strategis",
                href: "/admin/aksi/kajian-strategis",
                sourceHref: `${ceaBaseUrl}/siar/`,
                description: "Kajian strategis dan analisis isu prioritas aliansi.",
            },
            {
                key: "gugus-tugas",
                label: "Gugus Tugas",
                href: "/admin/aksi/gugus-tugas",
                sourceHref: `${ceaBaseUrl}/struktur-gerak-cea/`,
                description: "Kelompok kerja civic space dan civic engagement.",
            },
            {
                key: "kaukus-isu",
                label: "Kaukus Isu",
                href: "/admin/aksi/kaukus-isu",
                sourceHref: "https://menjadiindonesia.org",
                description: "Kaukus tematik dan kanal isu lintas sektor.",
            },
            {
                key: "diskursus",
                label: "Diskursus",
                href: "/admin/aksi/diskursus",
                sourceHref: `${ceaBaseUrl}/`,
                description: "Forum diskusi, percakapan publik, dan agenda pengetahuan.",
            },
        ],
    },
    {
        key: "koneksi",
        label: "KONEKSI",
        href: "/admin/koneksi",
        sourceHref: `${ceaBaseUrl}/`,
        description: "Kelola koneksi ekosistem, platform kolaborasi, dan kanal mitra Pooling Fund - KSO.",
        children: [
            {
                key: "lokadana",
                label: "Lokadana",
                href: "/admin/koneksi/lokadana",
                sourceHref: "https://lokadana.lokadaya.id",
                description: "Platform hibah partisipatif dan mobilisasi sumber daya.",
            },
            {
                key: "iwrf",
                label: "IWRF",
                href: "/admin/koneksi/iwrf",
                sourceHref: "https://iwrf.id",
                description: "Koneksi ke ekosistem Indonesia Women Rights Forum.",
            },
            {
                key: "idrf",
                label: "IDRF",
                href: "/admin/koneksi/idrf",
                sourceHref: "https://idrf.id",
                description: "Koneksi ke ekosistem Indonesia Development Research Forum.",
            },
            {
                key: "simpul-pfb",
                label: "Simpul PFB",
                href: "/admin/koneksi/simpul-pfb",
                sourceHref: `${ceaBaseUrl}/`,
                description: "Kanal simpul dan jejaring pendukung berbasis wilayah.",
            },
            {
                key: "baku-dapa",
                label: "Baku-Dapa",
                href: "/admin/koneksi/baku-dapa",
                sourceHref: "https://baku-dapa.id",
                description: "Ruang siar, radio komunitas, dan koneksi narasi bersama.",
            },
            {
                key: "telisik",
                label: "Telisik",
                href: "/admin/koneksi/telisik",
                sourceHref: `${ceaBaseUrl}/`,
                description: "Kanal observasi, pembacaan isu, dan penelusuran data.",
            },
            {
                key: "sociopath",
                label: "Sociopath",
                href: "/admin/koneksi/sociopath",
                sourceHref: "https://sociopath.id",
                description: "Platform sosial dan kanal kolaborasi ekosistem gerakan.",
            },
            {
                key: "sake-mite",
                label: "Sake-Mite",
                href: "/admin/koneksi/sake-mite",
                sourceHref: `${ceaBaseUrl}/`,
                description: "Kanal koneksi komunitas dan pertukaran praktik baik.",
            },
            {
                key: "civil-colony",
                label: "Civil Colony",
                href: "/admin/koneksi/civil-colony",
                sourceHref: `${ceaBaseUrl}/`,
                description: "Ruang kolektif untuk koneksi masyarakat sipil.",
            },
        ],
    },
    {
        key: "kolektif",
        label: "KOLEKTIF",
        href: "/admin/kolektif",
        sourceHref: `${ceaBaseUrl}/`,
        description: "Kelola narasi kolektif, testimoni simpul, dan arsip kolaborasi.",
    },
]

export const dropdownSections = ceaNavigation.filter((item) => item.children?.length)

export const getPublicHref = (item) => item.publicHref || item.href

export const getAdminSection = (sectionKey) => {
    return ceaNavigation.find((section) => section.key === sectionKey)
}

export const getAdminItem = (sectionKey, itemKey) => {
    const section = getAdminSection(sectionKey)
    if (!section?.children) return null
    const item = section.children.find((child) => child.key === itemKey)
    return item ? { ...item, section } : null
}

export const getAdminChildItems = () => {
    return dropdownSections.flatMap((section) =>
        section.children.map((item) => ({
            ...item,
            section,
            sectionKey: section.key,
            sectionLabel: section.label,
        }))
    )
}
