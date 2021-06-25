import React,{useState} from "react";
import "../style/loginpage.css"
import {Link} from 'react-router-dom'
import axios from 'axios';
import Button from '@material-ui/core/Button';

class Loginpage extends React.Component {
  state ={
    Email : "",
    Password: "",
    Data:{},
  }
  handleEmail = async e =>{
    await this.setState({
        Email : e.target.value, 
    })
  }
  handlePassword = async e =>{
    await this.setState({
        Password : e.target.value, 
    })
  }
  handleSubmit = e =>{
    e.preventDefault();
    console.log(this.state.Email);
    console.log(this.state.Password);
    let formData = new FormData();
    formData.append("Email",this.state.Email);
    formData.append("Password",this.state.Password);
    const url = "http://localhost/final_pro/login/login.php";
    axios.post(url,formData)
        .then(res=>{
          console.log(res.data)
          this.setState({ Data:res.data });
          this.props.setUser(this.state.Data[0].username)
          if(res.data==="No account"){
            alert("登入失敗")
          }
      })
    .catch(err => console.log(err));
  }
  render() {
    return (
      <div style={{
        width:"100vw", 
        height:"100vh", 
        display:"flex", 
        alignItems:"center",
        justifyContent:"center",
        }}>
        {this.props.user ? (
          <div className="robotButton">
            <Link   
            to ={{
            pathname:'/manager',
            aboutProps:{
            result:this.state.Data,
            }
            }}
            > 
            <Button variant="outlined" color="secondary">
                I am not a robot
            </Button>
            </Link>
          </div>
        ):(
          <div>
            <ul className="backgroundLogin">
                <li><span></span></li>
                <li><span></span></li>
                <li><span></span></li>
                <li><span></span></li>
                <li><span></span></li>
            </ul>
            <div className="LoginBox">
              <div className="team7-logologin" />
              <form>
                <div className="UserLogin">
                  <label htmlFor="userName" className="control-Element">
                    Email
                  </label>
                  <input
                    type="email"
                    className="login-control"
                    id="userName"
                    onChange={this.handleEmail}
                    aria-describedby="emailHelp"
                  />
                </div>
                <div className="UserLogin">
                  <label htmlFor="userpassword" className="control-Element">
                    Password
                  </label>
                  <input
                    type="password"
                    className="login-control"
                    id="userpassword"
                    onChange={this.handlePassword}
                  />
                </div>
    
                <input type="submit" className="submitLogin" value="Login" onClick={this.handleSubmit}/>
                {/* login button */}
    
    
                <div className="Login-forgetRegister">
                  <Link exact to="/register">
                    <a className="registerUser float-left" href="">
                      Register
                      &emsp;&emsp;&emsp;
                      &emsp;&emsp;&emsp;&emsp;
                    </a>
                  </Link>
                  <Link exact to = "/forgetpassword">
                    <a className="forgetPassword float-right" href="">
                      Forget Password?
                    </a>
                  </Link>
                </div>
              </form>
              <div className="clear" />
            </div>
    
            <div className="team7Copyright">
              <div className="container-fluid">
                <div className="team7CopyLeft">
                  <a href="">HouseForEld</a>
                  <a href="">About us</a>
                  <a href="">Instagram</a>
                </div>
    
                <div className="team7CopyRight">
                  Â© 2021, HouseForEld, A product of <a href="">DSA team7.</a>
                </div>
              </div>
            </div>
          </div>
        )}
      </div>
      
    );
  }
}
export default Loginpage;