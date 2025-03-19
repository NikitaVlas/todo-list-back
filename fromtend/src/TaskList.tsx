
import axios from "axios";
import {useEffect, useState} from "react";

interface Task {
    title: string;
    isCompleted: boolean;
}

function TaskList() {
    const [tasks, setTasks] = useState<Task[]>([]);
    const [title, setTitle] = useState("");

    useEffect(() => {
        axios.get("http://localhost:8000/api/task").then((res) => setTasks(res.data));
    }, []);

    const addTask = () => {
        axios.post("http://localhost:8000/api/task", { title }).then(() => {
            setTitle("");
            setTasks([...tasks, { title, isCompleted: false }]);
        });
    };

    return (
        <div>
            <h2>To-Do List</h2>
            <input value={title} onChange={(e) => setTitle(e.target.value)} />
            <button onClick={addTask}>Add Task</button>
            <ul>
                {tasks.map((task, index) => (
                    <li key={index}>{task.title}</li>
                ))}
            </ul>
        </div>
    );
}

export default TaskList;
