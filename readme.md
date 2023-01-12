Workflow Integration: Pharmacy Web App
============================================



##wichtig:
<li>die medikationsliste ist im upload-ordner zu finden.</li>
<li>der inhalt von output und upload kann gelöscht werden, die ordner selbst müssen jedoch im verzeichnis bleiben.

wenn es trotzdem nicht geht, php.ini suchen (zB im browser info.php öffnen, dort nach
"Loaded Configuation File suchen") und dort <code>file_uploads=On</code> setzen.</li>

## cave:
<li>die output-dateien werden noch beim einlesen erzeugt, nicht erst beim submitten.
heißt man kann die dosierung zwar in der form verändern, es verändert aber den output nicht...aber für die präsentation wirds es reichen</li>
<li>keine validierung der hochgeladenen datei und keine "schönen" fehlermedldungen</li>