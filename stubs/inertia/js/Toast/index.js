import { useToast } from 'vue-toastification'
import Toastification from '@/Components/Toastification'

export const toast = useToast()

export const successToast = ({ title = 'Notification', text }) => {
    return toast.success({
        component: Toastification,
        props: {
            variant: 'success',
            title,
            text,
        },
    })
}

export const errorToast = ({ title = 'Notification', text }) => {
    return toast.error({
        component: Toastification,
        props: {
            variant: 'error',
            title,
            text,
        },
    })
}

export const warnToast = ({ title = 'Notification', text }) => {
    return toast.error({
        component: Toastification,
        props: {
            variant: 'warning',
            title,
            text,
        },
    })
}

export const infoToast = ({ title = 'Notification', text }) => {
    return toast.error({
        component: Toastification,
        props: {
            variant: 'info',
            title,
            text,
        },
    })
}
