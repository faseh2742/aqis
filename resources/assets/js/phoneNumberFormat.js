class PhoneFormater {
    constructor(number) {
        this.phoneNumber = number
    }

    FormatPhone(phoneNumber) {
        if (phoneNumber) {
            let formatedNumber = ""
            let myRegex  = /(\d?\d?)([1-9]\d{2})(\d{3})(\d{4})$/g
            let matches = myRegex.exec(phoneNumber)

            if (matches) {
                if (phoneNumber.length > 10) {
                    formatedNumber = "+" + matches[1] + " " + matches[2] + "-" + matches[3] + "-" + matches[4]
                } else if(phoneNumber.length == 10) {
                    formatedNumber = "+1" + " " + matches[2] + "-" + matches[3] + "-" + matches[4]
                } else {
                    formatedNumber = phoneNumber
                }
            } else {
                formatedNumber = phoneNumber
            }

            return formatedNumber
        }
    }
}

export default PhoneFormater
