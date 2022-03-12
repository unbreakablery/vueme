
export const requireField = [ v => !!v || 'This field is required' ];
export const requireEmail = [
    v => !!v || 'This field is required',
    v => /.+@.+/.test(v) || 'The email is not valid',
];

export function getImage(path){

    let protocol = location.protocol;
    let slashes = protocol.concat("//");
    let host = slashes.concat(window.location.hostname);
    return host + '/'+path
}

export function objectToGetParameters(object){
    return Object.entries(object).filter(item => item[1]).map(([key, val]) => val?`${key}=${val}`:false).join('&');
}