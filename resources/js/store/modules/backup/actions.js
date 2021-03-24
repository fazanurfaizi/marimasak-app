import * as types from './mutation-types'

export const fetchBackups = ({ commit }, params) => {
    return new Promise((resolve, reject) => {
        window.axios.get('/backups', { params }).then((response) => {
            commit(types.SET_BACKUPS, response.data)
            resolve(response)
        })
        .catch((err) => {
            commit(types.SET_BACKUPS, false)
            reject(err)
        })
    })
}

export const createBackup = ({ commit }, data) => {
    return new Promise((resolve, reject) => {
        window.axios.post('/backups', data).then((response) => {
            resolve(response)
        })
        .catch((err) => {
            reject(err)
        })
    })
}

export const removeBackup = ({ commit }, params) => {
    return new Promise((resolve, reject) => {
        window.axios.delete(`/backups/${params.disk}`, { params }).then((response) => {
            resolve(response)
        })
        .catch((err) => {
            reject(err)
        })
    })
}
