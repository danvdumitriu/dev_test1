import React, { Component } from 'react';
import SortableTree, { addNodeUnderParent, removeNodeAtPath, changeNodeAtPath } from 'react-sortable-tree';
import 'react-sortable-tree/style.css'; // This only needs to be imported once in your app

const new_node = {
    title: '',
    name: '',
    children: [],
    expanded: false
}
export default class TreeStructure extends Component {
    constructor(props) {
        super(props);

        this.state = {
            treeData: [{
                title: 'Peter Olofsson',
                name: 'Peter Olofsson',
                children: [],
                expanded: false

            }, {
                title: 'Karl Johansson',
                name: 'Karl Johansson',
                children: [],
                expanded: false
            }]
        };
    }

    handleStateChange = (type) => {
        console.log("str",type,JSON.stringify(this.state));
    }

    render() {
        const getNodeKey = ({ treeIndex }) => treeIndex;
        const getRandomName = () =>
            firstNames[Math.floor(Math.random() * firstNames.length)];
        return (
            <div>
                <div style={{ height: 300 }}>
                    <SortableTree
                        onMoveNode={()=>{
                            this.handleStateChange("move");
                            console.log("move",this.state);
                        }}
                        treeData={this.state.treeData}
                        onChange={treeData => this.setState({ treeData })}
                        generateNodeProps={({ node, path }) => ({
                            title: (
                                <input
                                    style={{ fontSize: '1.1rem' }}
                                    value={node.name}
                                    onChange={event => {
                                        const name = event.target.value;

                                        this.setState(state => ({
                                            treeData: changeNodeAtPath({
                                                treeData: state.treeData,
                                                path,
                                                getNodeKey,
                                                newNode: { ...node, name, title:name }
                                            }),
                                        }), () => {
                                            console.log("edit name",this.state);
                                        });
                                    }}
                                    onBlur={event => {
                                        this.handleStateChange("blur after edit");
                                        console.log("blur",this.state);

                                    }}
                                />
                            ),
                            buttons: [
                                <button
                                    onClick={() =>
                                        this.setState(state => ({
                                            treeData: addNodeUnderParent({
                                                treeData: state.treeData,
                                                parentKey: path[path.length - 1],
                                                expandParent: true,
                                                getNodeKey,
                                                newNode: new_node,
                                                addAsFirstChild: state.addAsFirstChild,
                                            }).treeData,
                                        }), () => {
                                            this.handleStateChange("add child");
                                            console.log("add",this.state);
                                        })
                                    }
                                >
                                    Add Child
                                </button>,
                                <button
                                    onClick={() =>
                                        this.setState(state => ({
                                            treeData: removeNodeAtPath({
                                                treeData: state.treeData,
                                                path,
                                                getNodeKey,
                                            }),
                                        }), () => {
                                            this.handleStateChange("remove");
                                            console.log("remove",this.state);
                                        })
                                    }
                                >
                                    Remove
                                </button>,
                            ],
                        })}
                    />
                </div>

                <button
                    onClick={() =>
                        this.setState(state => ({
                            treeData: state.treeData.concat(new_node),
                        }), () => {
                            this.handleStateChange("add more");
                            console.log("add more",this.state);
                        })
                    }
                >
                    Add more
                </button>

            </div>
        );
    }
}