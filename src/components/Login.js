import { Link } from "react-router-dom";
import styled from "styled-components";

const Login =(props)=>{
    return(
        <Container>
            <Content>
                <Info>
                    You asked for the best<br></br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    We search for the rest
                </Info>
                {/* <startlogo>
                    SEARCH->
                </startlogo> */}
                <BgImage />
                <NextImg>
                    <Link exact to ="/checkbox">
                    <img src="/images/nextwhite.svg" alt="Browse" />
                    </Link>
                </NextImg>
            </Content>
        </Container>
    ); 
}

const Container = styled.section`
    overflow:hidden;  //if overflowed hide it
    display:flex;   //https://www.w3schools.com/cssref/playit.asp?filename=playcss_display&preval=inline
    flex-direction:column;//stack the items vertically
    text-align:center;
    height:100vh; //set height of element
`;

const Content = styled.div`
    margin-bottom:10vw;
    width:100%;
    position:relative;//https://www.w3schools.com/cssref/pr_class_position.asp
    min-height:100vh; //if content is smaller than min height,applied.If larger no affect
    box-sizing:border-box;  //Width and height apply to all parts of the element!!!MUST!! not letting it over extend 
    display:flex;
    justify-content:center; //justify content(https://w3c.hexschool.com/flexbox/4a029043)
    align-items:center;
    flex-direction:column;
    padding: 80px 40px; //generate space around the element
    height:100%
`;

const BgImage = styled.div`
    height:100%;
    background-image:url("/images/mansion1.jpg");
    background-position:top;
    background-size:cover;
    background-repeat:no-repeat;
    //background-attachment:fixed ---->when scrolled the page the picture will remain on the same pos
    position:absolute;//https://www.w3schools.com/cssref/pr_class_position.asp
    top:0;
    right:0;
    left:0;
    z-index:-1;//set background low priority
`;

const Info = styled.div`
    color:black;
    position:fixed;
    top:62vh;
    left:0;
    width: 35vw;
    //right: 50vw;
    height: 175px;
    background-color: #f9f9f9;
    opacity: 0.7;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 2.5%;
    letter-spacing: 1.2px;
    font-size: 3.5vh;
    z-index:auto;
    
    white-space: nowrap;
    overflow: hidden;
    
`;

const NextImg = styled.a`
    height:5vh;
    width: 5vw;
    position: relative;
    top:19vh;
    right:19.5vw;
    @media (max-width: 1800px) {
        top:21vh;
    }
`;
/* const CTA = styled.div`
    //margin-bottom:2vw;
    max-width:650px;
    width:100%;
    //flex-wrap:wrap;
    display:flex;               //when display: flex appeared
    flex-direction:column;      //flex-direction 
    /* justify-content:center;     //and justify-content can be selected
    margin-top:0;
    text-align: center;
    margin-right:auto;          //makes it responsive to page when tightened 
    margin-left: auto;
    transition-timing-function:ease out;//animation-timing-function
    transition:opacity 0.2s; 
`;

const CTALogoOne = styled.img`
    margin-bottom:12px;
    max-width:600px;
    min-height:1px;
    display:block;
    width:100%;

`;

const SignUp = styled.a`//button so give it a link type
    font-weight: bold;
    color:#f9f9f9;
    background-color:#0063e5;
    margin-bottom:12px;
    width:100%;
    letter-spacing:1.5px;
    font-size:18px;
    padding: 16.5px 0;
    border:1px solid transparent;
    border-radius:4px;

    &:hover{
        background-color: #0483ee;//change buttom color when moving mouse to it
    }
`; 

const Description = styled.p`//paragraph
     color:hsla(0,0%,95.3%,1);
     font-size:11px;
     margin:0 0 24px;
       line-height: 1.5;
     letter-spacing:1.5px;

 `; 

const CTALogoTwo = styled.img`
    max-width: 600px;
    margin-bottom:20px;
    display:inline-block;   //these two lines
    vertical-align: bottom; //and this------------->are not really necessary doesn't make much changes
    width: 100%;
`;*/


export default Login;