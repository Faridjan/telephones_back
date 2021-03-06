import React from 'react'
import {
  YMaps,
  Map,
  Button,
  ZoomControl,
  TypeSelector,
} from 'react-yandex-maps'

class App extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
      lastPolygon: null,
      dragg: true
    };
  }

  addPolygon = (e) => {
    const newPolygon = new this.ymapRef.Polygon(
      [[]],
      { hintContent: 'Многоугольник' },
      {
        draggable: this.state.dragg
        // editorDrawingCursor: 'crosshair',
        // editorMaxPoints: 5,
        // fillColor: '#00FF00',
        // strokeColor: '#0000FF',
        // strokeWidth: 5,
      }
    )

    this.state.lastPolygon = newPolygon

    // Adding the polygon to the map.
    this.mapRef.geoObjects.add(newPolygon)

    newPolygon.events.add('contextmenu', (e) => {
      const coords = e.get('coords')

      if (!this.mapRef.balloon.isOpen()) {
        this.mapRef.balloon.open(coords, {
          contentHeader:'Событие!',
              contentBody:'<p>Кто-то щелкнул по карте.</p>' +
          '<p>Координаты щелчка: ' + [
            coords[0].toPrecision(6),
            coords[1].toPrecision(6)
          ].join(', ') + '</p>',
              contentFooter:'<sup>Щелкните еще раз</sup>'
        })
      } else {
        this.mapRef.balloon.close();
      }
  })

    newPolygon.editor.startDrawing()
    newPolygon.editor.ondragend = function () {
      console.log('asdfasd')
    }
  }

  stopEditPolygon = (e) => {
    this.state.dragg = !this.state.dragg
    const lasPolygon = this.state.lastPolygon
    lasPolygon.editor.stopEditing()
    lasPolygon.editor.draggable = false
  }

  render() {
    return (
      <YMaps
        query={{
          lang: 'ru_RU',
          apikey: 'f8a4a7fe-f442-4a37-af5a-a4dec57c863f',
        }}
      >
        <Map
          instanceRef={(map) => {
            if (map) {
              this.mapRef = map
            }
          }}
          defaultState={{ center: [51.128207, 71.430411], zoom: 6 }}
          options={{ autoFitToViewport: 'always' }}
          height="100vh"
          width="100vw"
          modules={['Polygon', 'geoObject.addon.editor']}
          onLoad={(ref) => (this.ymapRef = ref)}
        >
          <ZoomControl />
          <TypeSelector />
          <Button
            options={{ maxWidth: 128 }}
            data={{ content: 'Добавить Метку'}}
            onClick={this.addPolygon}
          />
          <Button
              options={{ maxWidth: 128 }}
              data={{ content: 'Завершить редактировать'}}
              onClick={this.stopEditPolygon}
          />
        </Map>
      </YMaps>
    )
  }
}

export { App }
