import React from 'react';

import { BaseComponent } from '../BaseComponent/BaseComponent';
import User from '../User/User';
import './UserList.css';

class UserList extends BaseComponent {
  render() {
    return (
      <div className="UserList">
        {this.props.users.map(user => <User key={user.username} user={user} onRemove={this.props.onRemove} onAdd={this.props.onAdd} />)}
      </div>
    );
  }
}

export default UserList;
