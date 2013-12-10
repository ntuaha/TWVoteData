require! <[csv fs]>
var c, ci, candidate, header, county

result = {}
aggregated = {}

function parse-entry(row)
  votes = row[3 til 3+candidate.length].map -> +(it - /,/g)
  misc = {}
  for name, i in header when i > 1 and name?
      misc[name] = +(row[i] - /,/g)
  misc.投票率 = delete misc.發票率 / 100
  {得票數: votes, 得票率: votes.map -> +(it - /,/g) / misc.選舉人數} <<< misc

<- csv!from.stream process.stdin
.on \record (row, i) -> match i
    | 0 => [, c, ci?] := row.0.match /立法委員選舉(...)(?:第(\d+)選舉區|候選人)/
    | 1 => header := row.map -> it.match(/^([^各A-Z]+)/)?1
    | 2 => candidate := [p.split /\n/ for p in row when p isnt '']
    | (>= 5) =>
        if row.0.match /\S/
            county := row.0 - /\s/g
            if county isnt \總計
              result[county] = {}
            aggregated[county] = parse-entry row
        else
            result[county][row.1] ?= []
                ..push parse-entry row

    | otherwise =>
.on \end
console.log JSON.stringify {投票狀況: result, 候選人: candidate, 選區: [c, ci], 小記: aggregated}, null 4
