(window.webpackJsonp=window.webpackJsonp||[]).push([[149],{3625:function(e){e.exports=JSON.parse(`{"modules":{"tools":{"cosiFileImport":{"captions":{"introInfo":"Importieren Sie Ihre gew\xFCnschte Datei einfach per Drag and Drop oder alternativ mit dem \xD6ffnen-Dialog des Browsers.","introFormats":"Es k\xF6nnen KML-Dateien (*.kml), GPX-Dateien (*.gpx) oder GeoJson-Dateien (*.geojson, *.json) importiert werden.","introDrawTool":"Importierte Geometrien k\xF6nnen im Nachhinein ver\xE4ndert werden. Nutzen Sie hierf\xFCr das Werkzeug &quot;$t(common:menu.tools.draw)&quot;.","drawTool":"$t(common:menu.tools.draw) \xF6ffnen","dropzone":"Datei hier ablegen","selectCrs":"Projektionssystem ausw\xE4hlen","browse":"Datei ausw\xE4hlen","supportedFiletypes":{"auto":"Automatische Erkennung","kml":"KML-Datei (*.kml)","gpx":"GPX-Datei (*.gpx)","geojson":"GeoJson-Datei (*.geojson, *.json)"}},"alertingMessages":{"success":"Die Datei \\"{{filename}}\\" wurde erfolgreich importiert.","successPartly":"Die Datei \\"{{filename}}\\" wurde teilweise importiert.","formatError":"Die Datei \\"{{filename}}\\" konnte nicht gelesen werden. Bitte pr\xFCfen Sie, ob die Datei das Format *.kml. *.gpx, *.geojson oder *.json hat.","missingFileContent":"Fehler beim Lesen der Datei \\"{{filename}}\\". Bitte \xFCberpr\xFCfen Sie den Dateityp sowie den Inhalt der Datei. Falls die Datei fehlerfrei ist, wenden Sie sich bitte an den Support.","missingFormat":"Das Dateiformat {{format}} wird nicht unterst\xFCtzt. Bitte wenden Sie sich an den Support.","featureError":"Ein Feature in dieser Datei konnte nicht gelesen werden.","sameName":"Eine Datei mit dem Namen \\"{{filename}}\\" wurde bereits importiert. Bitte importieren Sie eine andere Datei oder \xE4ndern Sie den Dateinamen."},"labels":{"propName":"Name der Eigenschaft","selectProp":"Objekteigenschaft ausw\xE4hlen","typeProp":"Typen-Feld bestimmen","nameProp":"Namens-Feld bestimmen","styleProp":"Style-Feld ausw\xE4hlen","colorByAttribute":"Farbe nach Attributen"},"colorSelection":"Farbauswahl","rainbow":"Regenbogenfarbspektrum","successfullyImportedLabel":"Erfolgreich importiert:","title":"Geodaten importieren","layerButton":"Layer hinzuf\xFCgen","preNum":"Numerische Werte","filter":"Filterdaten","address":"Adressdaten","facility":"Einrichtungsdaten","styling":"Styling","featuresInfo":"Hier sehen Sie eine Liste aller m\xF6glicher Zahlwerte aus dem geladenen Layer, die Sie in unterschiedlichen Cosi-Tools zu Analysezwecken verwenden k\xF6nnen. W\xE4hlen Sie die relevanten Werte aus und benennen Sie sie auf Wunsch beliebig um.","featuresInfoStyling":"Hier bestimmen Sie bitte ein Styling, anhand dessen die Themen visualisiert werden sollen. Klicken Sie auf das farbige Viereck, um das Farbauswahlwerkzeug zu \xF6ffnen.","featuresInfoColor":"W\xE4hlen Sie hier eine Farbe aus. Mit Klick auf das farbige Viereck \xF6ffnen Sie das Farbauswahlwerkzeug","featuresInfoRainbow":"Visualisieren Sie die Themen gleichm\xE4\xDFig verteilt \xFCber ein Regenbogenfarbspektrum.","featuresInfoFilter":"Hier bestimmen Sie Objekteigenschaften, die das Programm ben\xF6tigt, um bestimmte Sortierfunktionen bereitzustellen.","featuresInfoAddress":"Es wurde kein Adresseintrag gefunden. Falls einzelne Angaben wie Stra\xDFennamen oder Postleitzahl verf\xFCgbar sind, w\xE4hlen Sie hier bitte die Objekteigenschaften aus, aus denen sich die Adresse zusammensetzt.","filterSelection":"Filterbare Objekteigenschaften","filterInfo":"W\xE4hlen Sie hier die Objekteigenschaften aus, die f\xFCr das Filterwerkzeug verf\xFCgbar gemacht werden sollen.","addSetToFilter":"Thema zum Filter hinzuf\xFCgen","preSelectedData":"Aus automatischen erkannten Objekteigenschaften ausw\xE4hlen","preSelectedDataFound":"Es wurden automatisch bestimmte Objekteigenschaften erkannt, die sich Adressdaten zuordnen lassen. Sollte diese Liste unvollst\xE4ndig sein, w\xE4hlen Sie bitte 'Aus allen Objekteigenschaften ausw\xE4hlen' an","viewAllData":"Aus allen Objekteigenschaften ausw\xE4hlen","pointsAndPolygons":"In der von Ihnen hochgeladenen Datei wurden sowohl Punkt- als auch Polygonfeatures erkannt. W\xFCnschen Sie ein gesonderte Farbe f\xFCr die Polygone?","createLayerInfo":"Stellen Sie hier bitte die Parameter ein, mit denen die Themen visualiert werden soll. Geben Sie auch die Werte an, die f\xFCr den Filter und die Versorgungsanalyse verf\xFCgbar sein sollen.","cancel":"Abbrechen","autoStyle":"Thematische Farbgebung","manualStyle":"Farbgebung definieren","autoStyleTooltip":"Sie k\xF6nnen hier ein Attribut aus der von Ihnen hochgeladenen Datei w\xE4hlen, auf Basis dessen Werten Farbvariationen erstellt werden, um eine informativere Visualisierung zu erm\xF6glichen.","rainbowTooltip":"Normalerweise werden die Daten anhand einer einzeln ausgew\xE4hlten Farbe visualisiert, auf denen Basis ein entsprechendes Farbspektrum generiert wird. Wenn Sie diese Option ausw\xE4hlen, werden die Farben hingegen, basierend auf der von Ihnen bestimmten Objekteigenschaft komplett gleichm\xE4\xDFig auf einem Regenbogenfarbspektrum verteilt. Dies ist nur f\xFCr nicht numerische Attribute sinnvoll.","typenfeldTooltip":"Sofern die von Ihnen hochgeladene Datei entsprechende Daten beinhaltet, w\xE4hlen Sie hier bitte die Objekteigenschaft aus, die den Typ jedes einzelnen Eintrags bestimmt. Wenn es sich beispielsweise einen Datensatz mit Geb\xE4udeinformationen handelt, w\xFCrden Sie hier eine Objekteigenschaft bestimmen, die Eintr\xE4ge wie 'Krankenhaus' oder 'Kindertagesst\xE4tte' enth\xE4lt o.\xE4.","namensfeldTooltip":"Sofern es eine Objekteigenschaft gibt, die eine individuelle Bezeichnung eines jeden Eintrags enth\xE4lt, geben Sie diese bitte hier an.","stylefeldTooltip":"Ausw\xE4hlen nach welchem Feld die Daten eingef\xE4rbt werden sollen","crsTooltip":"Sollten die Daten aus Ihrer Datei nicht an den korrekten Orten visualisiert werden, kann es sein, dass Ihre Datei in einem anderen Projektionssystem kodiert ist. Bitte finden Sie heraus, um welches Projektionssystem es sich handelt und w\xE4hlen Sie es beim Hochladen hier aus.","infoTooltip":"Werkzeuginformationen"}}}}`)}}]);
