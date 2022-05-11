import Errors from './Errors'
import Swal from "sweetalert2"

class Forms {
    constructor(data) {
        this.originalData = data;

        for (let field in data) {

            this[field] = data[field];

        }

        this.errors = new Errors();
    }

    data() {

        let data = {};

        for (let property in this.originalData) {

            data[property] = this[property];

        }

        return data;

    }

    reset() {
        for (let field in this.originalData) {

            this[field] = '';

        }

        this.errors.clear();
    }

    post(url) {

        return this.submit('post', url);

    }

    get(url) {

        return this.submit('get', url);

    }

    put(url) {

        return this.submit('put', url);

    }
    putWithoutReset(url) {

        return this.submit('put', url, false);

    }

    async deleteRecord(url, id, confirmtxt) {
        const result = await Swal.fire({
            title: "Are you sure?",
            text: `You won't be able to revert this!`,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "md-button md-success",
            cancelButtonClass: "md-button md-danger",
            confirmButtonText: "Yes, delete it!",
            buttonsStyling: false
        });
        if (result.value) {
            return new Promise((resolve, reject) => {
                axios.delete(url + id)
                    .then(response => {
                        Swal.fire({
                            title: "Deleted!",
                            text: confirmtxt,
                            type: "success",
                            confirmButtonClass: "md-button md-success",
                            buttonsStyling: false
                        });
                        resolve(response);
                    })
                    .catch(errors => {
                        if (errors.response.data.errors) {
                            this.onFailedSubmit(errors.response.data.errors);
                            reject(errors.response.data.errors);
                        } else {
                            this.onFailedSubmit(errors.response);
                            reject(errors.response);
                        }
                    });
            });
        }
    }


    submit(requestType, url, reset=true) {

        return new Promise((resolve, reject) => {

            axios[requestType](url, this.data())

                .then(response => {

                    this.onSuccessfulSubmit(response.data, reset);

                    resolve(response);

                })

                .catch(errors => {
                    if (errors.response.data.errors) {
                        this.onFailedSubmit(errors.response.data.errors);
                        reject(errors.response.data.errors);
                    } else {
                        this.onFailedSubmit(errors.response);
                        reject(errors.response);
                    }
                });

        });
    }

    onSuccessfulSubmit(data, reset = true) {
        if (reset) {
            this.reset()
        }

    }

    onFailedSubmit(errors) {

        this.errors.record(errors);

    }

    editForm(form, data) {
        for (let field in data) {
            // if (data[field]) {
                form[field] = data[field]
            // }
        }
    }
}

export default Forms
