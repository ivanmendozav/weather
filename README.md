# weather
Website example for weather forecasting by http://www.avalith.net/
@author: Ivan Mendoza
@publication date: 9 June 2020

Términos/archivos:
- OpenWeatherMap (OWM)
- config.php: Contiene URLs para las APIs, API key y constantes del programa
- owm.client.js: Realiza llamadas con AJAX hacia métodos del lado del servidor
- owm.proxy.js: Recibe las peticiones del cliente y realiza los requests a las APIs
- owm.class.php: Clase con los métodos estáticos para conectarse a las APIs

Para probar la aplicación entrar a: http://bambooshop.ec/weather

Estilos: archivo styles.css
- El diseño es simple, tiene una zona para mostrar el clima de hoy (temperatura máxima, mínima, promedio, humedad). 
- Abajo se muestra el histórico de los 5 últimos días y la predicción de los siguientes 7 días. 
- No está optimizado 100% para móviles sin embargo el diseño del histórico es de 3 columnas para pantallas mayores a 720px, y de 2 columnas para pantallas entre 480px y 720px. 
- Los íconos son estraídos del mismo sitio web de OWM

Se utilizan 3 servicios de la API de OpenWeatherMap (OWM), 
1- weather (reporte actual)
2- one call (reporte de los siguientes 7 días)
3- timemachine (reporte de los últimos 5 días)

