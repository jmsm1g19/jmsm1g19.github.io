import React from 'react';

import { BaseComponent } from '../BaseComponent/BaseComponent';
import UserList from '../UserList/UserList';
import './Team.css';

class Team extends BaseComponent {
  constructor(props) {
    super(props);
    this._bind('handleNameChange');
  }

  handleNameChange(event) {
    this.props.onNameChange(event.target.value);
  }

  render() {
    return (
      <div className="Team">
        <input defaultValue={this.props.name} onChange={this.handleNameChange} />
        <UserList users={this.props.users} onRemove={this.props.onRemove} />
        <a className="Team-save" onClick={this.props.onSave}>SAVE TEAM</a>
      </div>
    );
  }
}

export default Team;
