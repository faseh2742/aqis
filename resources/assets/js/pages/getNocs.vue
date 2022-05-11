<script>
let convert = require('xml-js')
    export default {
        created () {
            this.getNocs()
            
        },
        methods: {
            getNocs () {
                let xmls= '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"\ xmlns:xsd="http://www.w3.org/2001/XMLSchema"\ xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">\
                <soap:Body>\
                <GetUnitGroup xmlns="NOCWebService">\
                    <strUnitGroupNumber>*</strUnitGroupNumber>\
                    <bytIsTitleRequired>1</bytIsTitleRequired>\
                    <strTitle></strTitle>\
                    <bytTitleSearchType>0</bytTitleSearchType>\
                    <bytIsDescReq>0</bytIsDescReq>\
                    <strDesc></strDesc>\
                    <bytDescSearchType>0</bytDescSearchType>\
                    <bytIsAltRequired>0</bytIsAltRequired>\
                    <bytInAltOrRegular>0</bytInAltOrRegular>\
                    <bytAndOr>0</bytAndOr>\
                    <bytIsEffectDateReq>0</bytIsEffectDateReq>\
                    <strEffectDate></strEffectDate>\
                    <bytEffectDateRange>0</bytEffectDateRange>\
                    <bytIsRecordIDReq>0</bytIsRecordIDReq>\
                    <bytSortOrder>0</bytSortOrder>\
                    <bytSortField>0</bytSortField>\
                    <bytLangIn>0</bytLangIn>\
                    <bytLangOut>0</bytLangOut>\
                    <strToken>NKpmmwHtYIFTXiaMPQIwLSspjlWHxqpFhhVQpeLzjutafGyAAdJocwhxvLtknxyFpbjMNmLzKBWqZqqjPfvZmXCdsPAcbKEZ</strToken>\
                    <strYear>2016</strYear>\
                </GetUnitGroup>\
                </soap:Body>\
            </soap:Envelope>'

            let url= 'http://cnp-noc.services.gc.ca/WebServices/Service.asmx?wsdl'
                axios.defaults.crossDomain = true
                // axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.rootState.user.token 
                    return new Promise((resolve, reject) => {
                        axios
                        .post(url, xmls,
                            {headers:
                                {'Content-Type': 'text/xml',
                                'Access-Control-Allow-Origin' : 'http://aqis-vue-v1.aj/',
                                'Access-Control-Allow-Origin' : 'http://cnp-noc.services.gc.ca/WebServices/Service.asmx?wsdl',
                            }
                            })
                        .then(response => {
                            resolve(response)
                            let nocs = convert.xml2js(response, {compact: false, 
                                spaces: 4, 
                                alwaysChildren: false, 
                                ignoreDeclaration: true, 
                                ignoreAttributes: true,
                                })
                            let xmlText = nocs.elements[0].elements[1].elements[0].elements[0].elements[0].text

                            let jsonText = convert.xml2js(xmlText, {compact: true, alwaysArray: true, alwaysChildren: true, ignoreAttributes: true})
                            let parser = new DOMParser();
                            let xmlResult = parser.parseFromString(xmlText,"text/xml")
                            var x,y, i, nocCodes=[], titles=[];
                            x = xmlResult.getElementsByTagName("NUMBER")
                            y = xmlResult.getElementsByTagName("TITLE_E")

                            this.$store.state.nocList = []
                                for (i = 0; i< x.length; i++) {
                                    nocCodes.push(x[i].childNodes[0].nodeValue)
                                    }
                                for (i = 0; i< y.length; i++) { 
                                    titles.push(y[i].childNodes[0].nodeValue)
                                    }
                            let resultArray = nocCodes.map(function (x, i) { 
                                                    return {code:x, title:titles[i]} 
                                                })
                                this.$store.state.nocList = resultArray
                                console.log(resultArray)

                        })
                        .catch (errors => {
                            console.log(errors)
                            reject(errors)
                        })
                    })
            },

        }
    }
</script>