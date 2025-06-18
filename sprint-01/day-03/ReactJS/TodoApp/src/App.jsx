import { useState } from 'react';
import './App.css';

function App() {
  const taskTemplate = {
    title: '',
    status: 'todo',
    createdAt: '',
    priority: 'medium',
  };
  const [task, setTask] = useState(taskTemplate);
  const [tasks, setTasks] = useState([]);
  const [editIndex, setEditIndex] = useState(null);

  const addOrUpdateTask = () => {
    const newTask = {
      ...task,
      createdAt: new Date().toISOString(),
    };

    if (editIndex === null) {
      // Add mode
      setTasks([...tasks, newTask]);
    } else {
      // Edit mode
      const updatedTasks = [...tasks];
      updatedTasks[editIndex] = newTask;
      setTasks(updatedTasks);
      setEditIndex(null);
    }

    // Reset the form
    setTask(taskTemplate);
  };

  const deleteBtnHandler = (index) => {
    setTasks(tasks.filter((_, i) => i !== index));
    if (editIndex === index) {
      setEditIndex(null);
      setTask(taskTemplate);
    }
  };

  const editBtnHandler = (index) => {
    const taskToEdit = tasks[index];
    setTask(taskToEdit);
    setEditIndex(index);
  };

  return (
    <>
      <div>
        <h1>To Do List</h1>
      </div>
      <div className="card">
        <div>
          <input
            value={task.title}
            onChange={(e) => setTask({ ...task, title: e.target.value })}
            placeholder="Task title"
          />
          <select
            value={task.status}
            onChange={(e) => setTask({ ...task, status: e.target.value })}
          >
            <option value="todo">To do</option>
            <option value="in-progress">In progress</option>
            <option value="done">Done</option>
          </select>
          <select
            value={task.priority}
            onChange={(e) => setTask({ ...task, priority: e.target.value })}
          >
            <option value="high">High</option>
            <option value="medium">Medium</option>
            <option value="low">Low</option>
          </select>
        </div>
        <button onClick={addOrUpdateTask}>
          {editIndex === null ? 'Add Task' : 'Update Task'}
        </button>
        {editIndex !== null && (
            <button onClick={() => {
              setEditIndex(null);
              setTask(taskTemplate);
            }}>
              Cancel
            </button>
          )}
        {tasks.length > 0 ? (
          <ul>
            {tasks.map((t, index) => (
              <li key={index}>
                {t.title} - {t.status} - {t.priority}{' '}
                <button onClick={() => editBtnHandler(index)}>Edit</button>{' '}
                <button onClick={() => deleteBtnHandler(index)}>Delete</button>
              </li>
            ))}
          </ul>
        ) : (
          <div>No Tasks here yet. Add one.</div>
        )}
      </div>
    </>
  );
}

export default App;
