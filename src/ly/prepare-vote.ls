tw = require \../twgeojson/
mly = require \./data/mly-8.json
require! <[exec-sync printf fs optimist]>


[prefix, output] = optimist.argv._

by_c = {}
for {constuiency: [c, i]} in mly when c is /^...$/
    by_c[c] = Math.max null, by_c[c] ? 1, i ? 1

for c, max of by_c
    name = tw.county_code[c]
    file = "#prefix(#name).xls"
    for i in [1 to max]
        sheet = printf '第%02d選區' i
        outfile = "#output/#c-#i.csv"
        console.log "#file -> #outfile"
        continue if try(fs.statSync outfile)?size > 0
        exec-sync "/Applications/LibreOffice.app/Contents/MacOS/python ~/git/g0v/twlyparser/unoconv/unoconv -f csv -S #sheet -o #outfile '#file'"

