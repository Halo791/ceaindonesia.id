import { useEffect, useRef } from "react"

const regioPoints = [
    { name: "DI Yogyakarta", type: "Sekretariat", lat: -7.7956, lng: 110.3695 },
    { name: "Aceh", type: "Simpul Regio", lat: 5.5483, lng: 95.3238 },
    { name: "Sumatera Barat", type: "Simpul Regio", lat: -0.9471, lng: 100.4172 },
    { name: "DKI Jakarta", type: "Jaringan", lat: -6.2088, lng: 106.8456 },
    { name: "Jawa Barat", type: "Simpul Regio", lat: -6.9175, lng: 107.6191 },
    { name: "Jawa Timur", type: "Simpul Regio", lat: -7.2575, lng: 112.7521 },
    { name: "Kalimantan Barat", type: "Simpul Regio", lat: -0.0263, lng: 109.3425 },
    { name: "Kalimantan Timur", type: "Simpul Regio", lat: -0.5022, lng: 117.1536 },
    { name: "Sulawesi Selatan", type: "Simpul Regio", lat: -5.1477, lng: 119.4327 },
    { name: "Sulawesi Tengah", type: "Jaringan", lat: -0.9003, lng: 119.8779 },
    { name: "Nusa Tenggara Barat", type: "Simpul Regio", lat: -8.5833, lng: 116.1167 },
    { name: "Nusa Tenggara Timur", type: "Simpul Regio", lat: -10.1772, lng: 123.607 },
    { name: "Maluku", type: "Jaringan", lat: -3.6554, lng: 128.1908 },
    { name: "Papua", type: "Jaringan", lat: -2.5916, lng: 140.669 },
]

export default function CeaLeafletMap() {
    const mapRef = useRef(null)
    const containerRef = useRef(null)

    useEffect(() => {
        let cancelled = false

        async function initMap() {
            const L = await import("leaflet")

            if (cancelled || !containerRef.current || mapRef.current) return

            const map = L.map(containerRef.current, {
                center: [-2.7, 118.5],
                zoom: 5,
                minZoom: 4,
                maxZoom: 9,
                scrollWheelZoom: false,
                zoomControl: true,
            })

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            }).addTo(map)

            const icons = {
                "Sekretariat": "#b91c31",
                "Simpul Regio": "#1677d2",
                "Jaringan": "#a26d49",
            }

            regioPoints.forEach((point) => {
                const marker = L.marker([point.lat, point.lng], {
                    icon: L.divIcon({
                        className: "cea-map-pin",
                        html: `<span style="--pin-color: ${icons[point.type] || "#b91c31"}"></span>`,
                        iconAnchor: [13, 30],
                        iconSize: [26, 30],
                        popupAnchor: [0, -28],
                    }),
                    title: point.name,
                })

                marker
                    .addTo(map)
                    .bindPopup(`<strong>${point.name}</strong><br/><span>${point.type}</span>`)
            })

            const bounds = L.latLngBounds(regioPoints.map((point) => [point.lat, point.lng]))
            map.fitBounds(bounds, { padding: [34, 34] })
            mapRef.current = map
        }

        initMap()

        return () => {
            cancelled = true
            if (mapRef.current) {
                mapRef.current.remove()
                mapRef.current = null
            }
        }
    }, [])

    return <div className="cea-leaflet-map" ref={containerRef} aria-label="Peta simpul Pooling Fund - KSO" />
}
