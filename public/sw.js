;
//asignar un nombre y versión al cache
const CACHE_NAME = 'v2_cache_trans_la_garra',
  urlsToCache = [
    './',
    '../public/css/bootstrap.min.css',
    '../public/css/font-awesome.css',
    '../public/css/AdminLTE.min.css',
    '../public/css/blue.css',
    '../public/css/_all-skins.min.css',
    '../public/css/bootstrap-select.min.css',
    '../public/datatables/buttons.dataTables.min.css',
    '../public/datatables/responsive.dataTables.min.css',
    '../public/js/jquery.min.js',
    '../public/js/bootstrap.min.js',
    '../public/js/adminlte.min.js',
    '../public/datatables/jszip.min.js',
    '../public/datatables/pdfmake.min.js',
    '../public/datatables/jquery.dataTables.min.css',
    '../public/datatables/datatables.min.js',
    '../public/js/bootbox.min.js',
    '../public/js/bootstrap-select.min.js',
    '../public/datatables/buttons.colVis.min.js',
    '../public/datatables/buttons.html5.min.js',
    '../public/datatables/dataTables.buttons.min.js',
    './script.js',
    '../files/principal/img01.png',
    '../public/img/favicon.png'
  ]

//durante la fase de instalación, generalmente se almacena en caché los activos estáticos
self.addEventListener('install', e => {
  e.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache)
          .then(() => self.skipWaiting())
      })
      .catch(err => console.log('Falló registro de cache', err))
  )
})

//una vez que se instala el SW, se activa y busca los recursos para hacer que funcione sin conexión
self.addEventListener('activate', e => {
  const cacheWhitelist = [CACHE_NAME]

  e.waitUntil(
    caches.keys()
      .then(cacheNames => {
        return Promise.all(
          cacheNames.map(cacheName => {
            //Eliminamos lo que ya no se necesita en cache
            if (cacheWhitelist.indexOf(cacheName) === -1) {
              return caches.delete(cacheName)
            }
          })
        )
      })
      // Le indica al SW activar el cache actual
      .then(() => self.clients.claim())
  )
})

//cuando el navegador recupera una url
self.addEventListener('fetch', e => {
  //Responder ya sea con el objeto en caché o continuar y buscar la url real
  e.respondWith(
    caches.match(e.request)
      .then(res => {
        if (res) {
          //recuperar del cache
          return res
        }
        //recuperar de la petición a la url
        return fetch(e.request)
      })
  )
})
