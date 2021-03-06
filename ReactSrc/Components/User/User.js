import React from 'react';

import { BaseComponent } from '../BaseComponent/BaseComponent';
import './User.css';

class User extends BaseComponent {
  constructor(props) {
    super(props);
    this._bind('addUser', 'removeUser');
  }

  renderAction() {
    if (this.props.onAdd) {
      return <a className='User-action' onClick={this.addUser}>+</a>;
    } else {
      return <a className='User-action' onClick={this.removeUser}>-</a>;
    }
  }

  addUser() {
    this.props.onAdd(this.props.user);
  }

  removeUser() {
    this.props.onRemove(this.props.user);
  }

  render() {
    return (
      <div className="User">
        <div className="User-information">
          <h3>{this.props.user.name}</h3>
          <p>{this.props.user.watchid} | {this.props.user.username}</p>
        </div>
        {this.renderAction()}
      </div>
    );
  }
}

export default User;
