import {InputAdornment, TextField} from "@mui/material";
import {useEffect} from 'react'

export default function TextFieldMoney({label, value, id, setData, index, required, small}) {

    function maskMoney(valor) {
        let value = valor.replace('.', '').replace(',', '').replace(/\D/g, '')
        const options = {minimumFractionDigits: 2}
        const result = new Intl.NumberFormat('pt-BR', options).format(
            parseFloat(value) / 100
        )
        if (setData) setData(index, result)
    }

    return (
        <TextField
            id={id}
            size={small ? 'small' : ''}
            label={label} fullWidth required={required}
            InputProps={{startAdornment: <InputAdornment position="start">R$</InputAdornment>}}
            value={value === 0 ? '' : (value ?? '')}
            onChange={e => maskMoney(e.target.value)}/>
    );
}
