/**
 * Script opcional para sembrar MongoDB con mongosh o Node.js
 * Uso en terminal:
 *   mongosh "mongodb://localhost:27017/fs2026_proyecto" seed_mongo.js
 */

const productos = [
    {
        id: 1,
        nombre: "Hojas Papel de Azúcar A4",
        categoria: "Hojas Comestibles",
        descripcion: "Pack x 24 hojas flexibles con acabado de gran nitidez para repostería",
        precio: 210.00,
        stock: 35,
        disponibilidad: "En Stock",
        tag: "Más Vendido",
        tag_class: "badge-tag-mas-vendido",
        icono: "bi-file-earmark-richtext"
    },
    {
        id: 2,
        nombre: "Kit Tintas Comestibles CMYK",
        categoria: "Tintas Comestibles",
        descripcion: "4 botellas 100ml c/u (Cian, Magenta, Amarillo, Negro) grado alimenticio",
        precio: 350.00,
        stock: 18,
        disponibilidad: "En Stock",
        tag: "Oferta",
        tag_class: "badge-tag-oferta",
        icono: "bi-droplet-half"
    },
    {
        id: 3,
        nombre: "Impresión Foto Pastel A4",
        categoria: "Impresiones Personalizadas",
        descripcion: "Servicio personalizado con foto en hoja de azúcar de alta resolución",
        precio: 45.00,
        stock: 99,
        disponibilidad: "Entrega Inmediata",
        tag: "Servicio",
        tag_class: "badge-tag-servicio",
        icono: "bi-camera"
    },
    {
        id: 4,
        nombre: "Hojas Papel de Arroz A4",
        categoria: "Hojas Comestibles",
        descripcion: "Pack x 24 obleas comestibles para galletas, merengues y turrón",
        precio: 125.00,
        stock: 24,
        disponibilidad: "En Stock",
        tag: "Insumo Base",
        tag_class: "badge-tag-insumo-base",
        icono: "bi-file-earmark"
    },
    {
        id: 5,
        nombre: "Discos Cupcake (x12 5cm)",
        categoria: "Impresiones Personalizadas",
        descripcion: "12 toppers redondos precortados impresos en azúcar para cupcakes",
        precio: 35.00,
        stock: 50,
        disponibilidad: "Entrega Inmediata",
        tag: "Popular",
        tag_class: "badge-tag-popular",
        icono: "bi-circle"
    },
    {
        id: 6,
        nombre: "Tinta Comestible Negra 100ml",
        categoria: "Tintas Comestibles",
        descripcion: "Alta densidad para bordes definidos y textos nítidos en pasteles",
        precio: 95.00,
        stock: 40,
        disponibilidad: "En Stock",
        tag: "Stock Alto",
        tag_class: "badge-tag-stock-alto",
        icono: "bi-paint-bucket"
    },
    {
        id: 7,
        nombre: "Impresora Canon Adaptada",
        categoria: "Impresoras Adaptadas",
        descripcion: "Equipada y lista para uso exclusivo con tintas comestibles alimentarias",
        precio: 1850.00,
        stock: 5,
        disponibilidad: "En Stock",
        tag: "Equipo",
        tag_class: "badge-tag-equipo",
        icono: "bi-printer"
    },
    {
        id: 8,
        nombre: "Limpiador Cabezales 100ml",
        categoria: "Soluciones de Limpieza",
        descripcion: "Líquido grado alimentario para mantenimiento y destape de inyectores",
        precio: 65.00,
        stock: 15,
        disponibilidad: "En Stock",
        tag: "Mantenimiento",
        tag_class: "badge-tag-mantenimiento",
        icono: "bi-wrench-adjustable"
    }
];

if (typeof db !== 'undefined') {
    db.productos.deleteMany({});
    db.productos.insertMany(productos);
    print("¡Productos insertados con éxito en la colección 'productos' de MongoDB!");
}
