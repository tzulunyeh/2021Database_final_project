import React from "react";
import "../style/loginpage.css"
import axios from 'axios';
import {Link} from 'react-router-dom'
class Register extends React.Component {
  state ={
    UserName : "",
    Email : "",
    Password: "",
    SecondConfirm:"",
  }
  handleUserName = async e =>{
    await this.setState({
        UserName : e.target.value, 
    })
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
  handleSecondConfirm = async e =>{
    await this.setState({
        SecondConfirm : e.target.value, 
    })
  }
  handleSubmit = e =>{
    e.preventDefault();
    console.log(this.state.Email);
    console.log(this.state.Password);
    let formData = new FormData();
    formData.append("UserName",this.state.UserName);
    formData.append("Email",this.state.Email);
    formData.append("Password",this.state.Password);
    formData.append("SecondConfirm",this.state.SecondConfirm);
    const url = "https://35.174.176.147/final_pro/login/register.php";
    axios.post(url,formData)
    .then(res=>{
      console.log(res.data)
      if(res.data==="<script>alert('YOU CAN REGISTER NOW!')</script>"){
        alert("請輸入資料")
      }
      else if(res.data==="<script>alert('Woops! account Already Exists.')</script>"){
        alert("已經有此帳號")
      }
      else if(res.data==="<script>alert('Wow! User Registration Completed.')</script>"){
        alert("註冊成功")
        this.setState({
          UserName : "",
          Email : "",
          Password: "",
          SecondConfirm:"",
        })
      }
    })
    .catch(err=>console.log(err));
  }
  render() {
    return (
      <div>
        {
          this.props.reg ? (
            console.log(this.props.reg)
          ) : (
              console.log(this.props.reg),
              window.open('http://35.174.176.147/final_pro/login/register.php', '_blank'),
              this.props.setreg(true)
        )}
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
              <label htmlFor="accountName" className="control-Element">
                User Name:
              </label>
              <input
                type="User-Name"
                className="login-control"
                id="Account"
                onChange={this.handleUserName}
              />
            </div>
            <div className="UserLogin">
              <label htmlFor="userName" className="control-Element">
                Email
              </label>
              <input
                type="email"
                className="login-control"
                id="userName"
                aria-describedby="emailHelp"
                onChange={this.handleEmail}

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
            <div className="UserLogin">
              <label htmlFor="SecondConfirm" className="control-Element">
                Second Confirm:
              </label>
              <input
                type="password"
                className="login-control"
                id="userName"
                onChange={this.handleSecondConfirm}
              />
            </div>
            <input type="submit" className="submitLogin" value="Register" onClick={this.handleSubmit}/>
            {/* login button */}


            <div className="Login-forgetRegister">
                <Link exact to="/loginpage">
                    <a className="registerUser float-left" href="">
                        Previous Page
                        &emsp;&emsp;&emsp;
                        &emsp;&emsp;&emsp;&emsp;
                    </a>
                </Link>
              {/* <a className="forgetPassword float-right" href="">
              </a> */}
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
    );
  }
}
export default Register;