import React from "react";
import {Link} from 'react-router-dom'
import styled from 'styled-components';
class ForgetPassword extends React.Component{
    render(){
        return(
                <Bitch>
                    <h1 style={{color:"black"}}>
                    <span style={{color:"black"}}>我們也無能為力</span>
                    請重新辦一個帳號
                    </h1>
                </Bitch>
        )
    }
}

const Bitch=styled.div`
    align-items: center;
    text-align:center;
    margin-top: 50vh;
    line-break: auto;
`;
export default ForgetPassword;