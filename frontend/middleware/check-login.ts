import { Context } from '@nuxt/types';
import Cookies from 'js-cookie'

export default function (context: Context) {
  if (!process.client) {
    if (context.req.headers.cookie) {
      const _cookies: Array<string> = context.req.headers.cookie.split(';')
      const token: string|undefined = _cookies.find(c => c.trim().startsWith('auth_token='))?.split('=')[1]
      if (token) {
        context.store.commit('auth/setToken', { token })
      }
    }
  } else {
    const token: string|undefined = Cookies.get('auth_token')
    if (token) {
      context.store.commit('auth/setToken', { token })
    }
  }
}
