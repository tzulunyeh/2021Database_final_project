//space between : obj        obj         obj
//display:flex
//align-items:center --->to makes it vertically centered to the box
import { Link } from 'react-router-dom';
import styled from 'styled-components';


const HeaderLoged =(props)=>{
    return(
        <Nav>
            <Link exact to="/">
                <Logo>
                    <img src="/images/team7.svg" alt="disney+"/>
                    <span>House For Eld</span>
                </Logo>
            </Link>
            

            <Login>
                <Link exact to="/">
                    <button onClick={e=>(props.setUser())}>Logout</button>
                </Link>
            </Login>
        </Nav>
    )
}

const Nav = styled.nav`
    position:fixed;
    top:0;
    left:0;
    right: 0;
    height: 70px;
    background-color: #f9f9f9;
    opacity: 0.7;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 36px;
    letter-spacing: 16px;
    z-index:3;

`;

const Logo = styled.a`
    padding:0;
    width:80px;
    height: 80px;
    margin-top: 4px;
    max-height: 70px;
    font-size: 0;
    display: flex;
    z-index:2;
    img{
        display: block;
        width: 80%;
    }
    span{
        align-items: center;
        color: black;
        font-size:30px;
        letter-spacing: 1.42px;
        line-height: 1.08;
        padding:2px 0px;
        white-space: nowrap;
        position:relative;
        margin-top: 18px;
        font-family: 'Brush Script MT',cursive;
    }
`;

const NavMenu = styled.div`         //it's on right cuz justify content is space between
    align-items:center;
    display:flex;
    flex-flow:row nowrap;           //flex direction & flex wrap
    height: 100%;
    justify-content: flex-end;
    margin: 0px;
    padding: 0px;
    position: relative;
    margin-right: auto;
    margin-left: 25px;

    a{
        display: flex;
        align-items: center;
        padding: 0 12px;
        
        img{
            height: 20px;
            min-width: 20px;
            width:20px;
            z-index:auto;
        }
        span{
            color: rpg(249,249,249);
            font-size:13px;
            letter-spacing: 1.42px;
            line-height: 1.08;
            padding:2px 0px;
            white-space: nowrap;
            position:relative;
            font-family: 'Adine Kirnberg',sans-serif;


            &:before{
                background-color: rgb(249, 249, 249);
                border-radius: 0px 0px 4px 4px ;
                bottom:-6px;
                content: "";
                height: 2px;
                left: 0px;
                opacity: 0;
                position: absolute; //because it needs to put under the home icon
                right: 0px;         //right under the home cuz the
                transform-origin: left center;
                transform: scaleX(0);//animation
                transition: all 250ms cubic-bezier(0.25,0.46,0.45,0.94) 0s; //the animation
                visibility: hidden;
                width: auto;
            }
        }

        &:hover{
            span:before{
                transform:scaleX(1);
                visibility: visible;
                opacity: 1 !important;
            }
        }
    }
    /* @media(max-width:768px){
        display: none;
    } */
`;

const Login = styled.a`
    button{
        color:white;
        background-color:black;
        padding:8px 16px;
        text-transform:uppercase;
        letter-spacing: 1.5px;
        border : 1px solid black;
        border-radius:4px;
        transition: all 0.2s ease 0s;

        &:hover{
            background-color: #A0A0A0;
            color:#000;
            border-color:transparent
        }
    }
    
`;

export default HeaderLoged