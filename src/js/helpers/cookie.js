export const cookie = {
    setItem: (name, value = '', days = 30) => {
        const date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/`;
    },
    getItem: (name) => {
        const ca = document.cookie.split(';');
        for(let i=0;i < ca.length;i++) {
            let c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(`${name}=`) == 0) return c.substring(`${name}=`.length,c.length);
        }
        return null;
    },
    removeItem: (name) => {   
        document.cookie = `${name}=; Max-Age=-99999999;`;
    }
}

