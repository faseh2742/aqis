import store from '../store'

export const permissions = {
    data() {
        return {
            roles: {
                dashboard: ['Admin', 'Facilitator'],
                userprofile: ['Admin', 'Facilitator'],

                clients: ['Admin', 'Facilitator'],
                facilitators: ['Admin'],
                aptemplates: ['Admin'],
                schedules: ['Admin'],
                reports: ['Admin'],
                dropdowns: ['Admin'],
                languages: ['Admin'],
                cities: ['Admin'],
                permissions: ['Admin'],
                outcomes: ['Admin'],
                referrals: ['Admin'],
            },
        }
    },

    methods: {
        canRead(permission) {
            return this.checkPermissions(permission, 1)
        },

        canWrite(permission) {
            return this.checkPermissions(permission, 2)
        },

        canDelete(permission) {
            return this.checkPermissions(permission, 3)
        },

        checkPermissions(permission, level) {
            if (Object.keys(store.state.user.permission).length === 0) {
                if (this.roles[permission].includes(store.state.user.role)) {
                    return true;
                }
                return false;
            }

            if (store.state.user.permission[permission] >= level) {
                return true;
            }
            return false;
        }
    }
}
